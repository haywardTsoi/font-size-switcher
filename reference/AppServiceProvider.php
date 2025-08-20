<?php

namespace App\Providers;

use Filament\Forms\Components\RichEditor;
use Filament\Support\Assets\Css;
use Filament\Support\Colors\Color;
use Filament\Support\Facades\FilamentAsset;
use Filament\Support\Facades\FilamentColor;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Routing\UrlGenerator;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        UrlGenerator::macro('alternateHasCorrectSignature', function (Request $request, $absolute = true, array $ignoreQuery = []) {
            $ignoreQuery[] = 'signature';

            // ensure the base path is applied to absolute url
            $absoluteUrl = url($request->path()); // forceRootUrl and forceScheme will apply
            $url = $absolute ? $absoluteUrl : '/' . $request->path();

            $queryString = collect(explode('&', (string) $request->server->get('QUERY_STRING')))
                ->reject(fn ($parameter) => in_array(Str::before($parameter, '='), $ignoreQuery))
                ->join('&');
            $original = rtrim($url . '?' . $queryString, '?');

            $keys = call_user_func($this->keyResolver);

            $keys = is_array($keys) ? $keys : [$keys];

            foreach ($keys as $key) {
                if (hash_equals(
                    hash_hmac('sha256', $original, $key),
                    (string) $request->query('signature', '')
                )) {
                    return true;
                }
            }
        });

        UrlGenerator::macro('alternateHasValidSignature', function (Request $request, $absolute = true, array $ignoreQuery = []) {
            return \URL::alternateHasCorrectSignature($request, $absolute, $ignoreQuery)
                && \URL::signatureHasNotExpired($request);
        });

        Request::macro('hasValidSignature', function ($absolute = true, array $ignoreQuery = []) {
            return \URL::alternateHasValidSignature($this, $absolute, $ignoreQuery);
        });

        // temp fix to autograph select styles
        FilamentAsset::register([
            Css::make('fix-select', __DIR__ . '/../../resources/css/fix-select.css'),
        ]);

        // Register the FontSizeControl component
        Blade::component('font-size-control', \App\View\Components\FontSizeControl::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        if (! str_contains(env('APP_URL'), 'localhost')) {
            \URL::forceScheme('https');
        }

        FilamentColor::register([
            'cyan' => Color::Cyan,
            'amber' => Color::Amber,
        ]);

        Gate::policy(\Tapp\FilamentMailLog\Models\MailLog::class, \App\Policies\MailLogPolicy::class);
        Gate::policy(\Rappasoft\LaravelAuthenticationLog\Models\AuthenticationLog::class, \App\Policies\AuthenticationLogPolicy::class);
        Gate::policy(\SolutionForest\FilamentFirewall\Models\Ip::class, \App\Policies\IpPolicy::class);

        Table::configureUsing(function (Table $table): void {
            $table
                ->poll('5s');
        });

        // temp fix to RichEditor in repeater
        RichEditor::configureUsing(
            fn (RichEditor $component) => $component->beforeStateDehydrated(function (RichEditor $component, $rawState, ?Model $record): void {
                $fileAttachmentProvider = $component->getFileAttachmentProvider();

                if ($fileAttachmentProvider?->isExistingRecordRequiredToSaveNewFileAttachments() && (! $record)) {
                    return;
                }

                $fileAttachmentIds = [];

                $component->rawState(
                    $component->getTipTapEditor()
                        ->setContent($rawState ?? [
                            'type' => 'doc',
                            'content' => [],
                        ])
                        ->descendants(function (object &$node) use ($component, &$fileAttachmentIds): void {
                            if ($node->type !== 'image') {
                                return;
                            }

                            if (blank($node->attrs->id ?? null)) {
                                return;
                            }

                            $attachment = $component->getUploadedFileAttachment($node->attrs->id);

                            if ($attachment) {
                                $node->attrs->id = $component->saveUploadedFileAttachment($attachment);
                                $node->attrs->src = $component->getFileAttachmentUrl($node->attrs->id);

                                $fileAttachmentIds[] = $node->attrs->id;

                                return;
                            }

                            if (filled($component->getFileAttachmentUrl($node->attrs->id))) {
                                $fileAttachmentIds[] = $node->attrs->id;

                                return;
                            }

                            $fileAttachmentIdFromAnotherRecord = $component->saveFileAttachmentFromAnotherRecord($node->attrs->id);

                            if (blank($fileAttachmentIdFromAnotherRecord)) {
                                $fileAttachmentIds[] = $node->attrs->id;

                                return;
                            }

                            $node->attrs->id = $fileAttachmentIdFromAnotherRecord;
                            $node->attrs->src = $component->getFileAttachmentUrl($fileAttachmentIdFromAnotherRecord) ?? $node->attrs->src ?? null;
                        })
                        ->getDocument(),
                );

                $fileAttachmentProvider?->cleanUpFileAttachments(exceptIds: $fileAttachmentIds);
            }, shouldUpdateValidatedStateAfter: true)
        );
    }
}

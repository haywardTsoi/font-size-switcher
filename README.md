# Font Size Switcher Plugin for Filament

[![Latest Version on Packagist](https://img.shields.io/packagist/v/solutionforest/font-size-switcher.svg?style=flat-square)](https://packagist.org/packages/solutionforest/font-size-switcher)
[![GitHub Tests Action Status](https://img.shields.io/github/workflow/status/solutionforest/font-size-switcher/run-tests?label=tests)](https://github.com/solutionforest/font-size-switcher/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/workflow/status/solutionforest/font-size-switcher/Fix%20PHP%20code%20style%20issues?label=code%20style)](https://github.com/solutionforest/font-size-switcher/actions?query=workflow%3A"Fix+PHP+code+style+issues"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/solutionforest/font-size-switcher.svg?style=flat-square)](https://packagist.org/packages/solutionforest/font-size-switcher)

一個為 Filament 管理面板提供字體大小切換功能的插件，讓用戶可以輕鬆調整界面字體大小以提升可讀性。

![Font Size Switcher Demo](demo.gif)

## 功能特點

- ✅ **即插即用**: 一行代碼輕鬆集成
- ✅ **響應式設計**: 適配桌面和移動設備
- ✅ **深色模式支持**: 完美配合 Filament 的深色主題
- ✅ **持久化儲存**: 自動保存用戶選擇到 localStorage
- ✅ **自定義配置**: 支持自定義字體大小比例
- ✅ **無障礙友好**: 提升可讀性和用戶體驗
- ✅ **輕量級**: 不影響應用性能

## 需求

- PHP 8.2+
- Laravel 10.0+
- Filament 4.0+

## 安裝

通過 Composer 安裝:

```bash
composer require solutionforest/font-size-switcher
```

可選：發布配置文件

```bash
php artisan vendor:publish --tag="font-size-switcher-config"
```

## 基本使用

在你的 Filament Panel Provider 中註冊插件:

```php
use Solutionforest\FontSizeSwitcher\FontSizeSwitcherPlugin;

public function panel(Panel $panel): Panel
{
    return $panel
        // ... 其他配置
        ->plugins([
            FontSizeSwitcherPlugin::make()
                ->xs(0.8)
                ->md(1)
                ->lg(1.2),
        ]);
}
```

就是這麼簡單！字體大小切換器將自動出現在 Filament 的頂部導航欄中。

## 高級配置

### 自定義字體大小

```php
FontSizeSwitcherPlugin::make()
    ->xs(0.75)     // 特小字體 (75%)
    ->sm(0.875)    // 小字體 (87.5%)
    ->md(1.0)      // 中等字體 (100% - 默認)
    ->lg(1.125)    // 大字體 (112.5%)
    ->xl(1.25)     // 特大字體 (125%)
```

### 設置默認字體大小

```php
FontSizeSwitcherPlugin::make()
    ->xs(0.8)
    ->md(1)
    ->lg(1.2)
    ->defaultSize('md') // 設置默認為中等字體
```

### 自定義顯示選項

```php
FontSizeSwitcherPlugin::make()
    ->xs(0.8)
    ->md(1)
    ->lg(1.2)
    ->showInTopbar(true)  // 顯示在頂部導航欄
    ->position('right')   // 位置: 'left' 或 'right'
```

### 完整配置示例

```php
use Solutionforest\FontSizeSwitcher\FontSizeSwitcherPlugin;

public function panel(Panel $panel): Panel
{
    return $panel
        ->id('admin')
        ->path('/admin')
        ->login()
        ->plugins([
            FontSizeSwitcherPlugin::make()
                ->xs(0.8)
                ->sm(0.9)
                ->md(1.0)
                ->lg(1.1)
                ->xl(1.2)
                ->defaultSize('md')
                ->showInTopbar(true)
                ->position('right'),
        ]);
}
```

## 方法參考

| 方法 | 參數 | 描述 |
|------|------|------|
| `xs(float)` | `$scale` | 設置特小字體比例 |
| `sm(float)` | `$scale` | 設置小字體比例 |
| `md(float)` | `$scale` | 設置中等字體比例 |
| `lg(float)` | `scale` | 設置大字體比例 |
| `xl(float)` | `$scale` | 設置特大字體比例 |
| `defaultSize(string)` | `$size` | 設置默認字體大小 |
| `showInTopbar(bool)` | `$show` | 是否顯示在頂部導航欄 |
| `position(string)` | `$position` | 設置位置 ('left' 或 'right') |

## 配置文件

發布配置文件後，你可以在 `config/font-size-switcher.php` 中自定義默認設置：

```php
return [
    'default_font_sizes' => [
        'sm' => 0.875,
        'md' => 1.0,
        'lg' => 1.125,
    ],
    
    'default_size' => 'md',
    
    'display' => [
        'show_in_topbar' => true,
        'position' => 'right',
    ],
    
    // ... 更多配置
];
```

## JavaScript 事件

插件會發送自定義事件，你可以監聽這些事件來執行額外的操作：

```javascript
// 監聽字體大小變更事件
window.addEventListener('filament-font-size-changed', function(event) {
    console.log('Font size changed to:', event.detail.size);
    console.log('Scale multiplier:', event.detail.multiplier);
});
```

## 瀏覽器支持

- Chrome/Edge: 最新版本
- Firefox: 最新版本  
- Safari: 最新版本
- IE: 不支持

## 測試

```bash
composer test
```

## 代碼風格檢查

```bash
composer pint
```

## 靜態分析

```bash
composer analyse
```

## 更新日誌

請查看 [CHANGELOG](CHANGELOG.md) 了解最近的更改。

## 貢獻

請查看 [CONTRIBUTING](CONTRIBUTING.md) 了解詳細信息。

## 安全漏洞

請查看我們的 [安全政策](../../security/policy) 了解如何報告安全漏洞。

## 授權

MIT 授權。請查看 [License File](LICENSE.md) 了解更多信息。

## 致謝

- [Filament](https://filamentphp.com) - 優秀的 Laravel 管理面板
- [Spatie](https://spatie.be) - Laravel 包工具
- 所有的 [貢獻者](../../contributors)

---

由 [Solution Forest](https://solutionforest.com) 用 ❤️ 製作



This is where your description should go. Limit it to a paragraph or two. Consider adding a small example.

## Installation

You can install the package via composer:

```bash
composer require solutionforest/font-size-switcher
```

> [!IMPORTANT]
> If you have not set up a custom theme and are using Filament Panels follow the instructions in the [Filament Docs](https://filamentphp.com/docs/4.x/styling/overview#creating-a-custom-theme) first.

After setting up a custom theme add the plugin's views to your theme css file or your app's css file if using the standalone packages.

```css
@source '../../../../vendor/solutionforest/font-size-switcher/resources/**/*.blade.php';
```

You can publish and run the migrations with:

```bash
php artisan vendor:publish --tag="font-size-switcher-migrations"
php artisan migrate
```

You can publish the config file with:

```bash
php artisan vendor:publish --tag="font-size-switcher-config"
```

Optionally, you can publish the views using

```bash
php artisan vendor:publish --tag="font-size-switcher-views"
```

This is the contents of the published config file:

```php
return [
];
```

## Usage

```php
$fontSizeSwitcher = new Solutionforest\FontSizeSwitcher();
echo $fontSizeSwitcher->echoPhrase('Hello, Solutionforest!');
```

## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](.github/CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](.github/SECURITY.md) on how to report security vulnerabilities.

## Credits

- [haywardtsoi](https://github.com/haywardTsoi)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

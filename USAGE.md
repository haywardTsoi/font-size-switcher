# Font Size Switcher Plugin for Filament

一個為 Filament 管理面板提供字體大小切換功能的插件。

## 安裝

通過 Composer 安裝:

```bash
composer require solutionforest/font-size-switcher
```

發布 assets:

```bash
php artisan vendor:publish --tag=font-size-switcher-assets
```

## 使用方法

在你的 Filament Panel Provider 中註冊插件:

```php
use Solutionforest\FontSizeSwitcher\FontSizeSwitcherPlugin;

public function panel(Panel $panel): Panel
{
    return $panel
        // ... 其他配置
        ->plugins([
            FontSizeSwitcherPlugin::make()
                ->small(0.8)
                ->normal(1.0)
                ->large(1.2),
        ]);
}
```

## 配置選項

### 基本用法

```php
FontSizeSwitcherPlugin::make()
    ->small(0.8)      // 小字體 (80%)
    ->normal(1.0)     // 正常字體 (100% - 默認)
    ->large(1.2)      // 大字體 (120%)
```

### 自定義默認大小

```php
FontSizeSwitcherPlugin::make()
    ->small(0.8)
    ->normal(1.0)
    ->large(1.2)
    ->defaultSize('normal') // 設置默認字體大小
```

## 完整示例

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
                ->small(0.8)
                ->normal(1.0)
                ->large(1.2)
                ->defaultSize('normal'),
        ]);
}
```

## 功能特點

- ✅ 顯示在全局搜索框之前 (`panels::global-search.before`)
- ✅ 響應式設計，適配桌面和移動設備
- ✅ 支持 Filament 的深色模式
- ✅ 自動保存用戶選擇的字體大小到 localStorage
- ✅ 支持自定義字體大小比例
- ✅ 分離的 CSS/JS 文件
- ✅ 易於配置和使用

## 瀏覽器支持

- Chrome/Edge: 最新版本
- Firefox: 最新版本  
- Safari: 最新版本

## 許可證

MIT 許可證。詳情請查看 [LICENSE](LICENSE.md) 文件。

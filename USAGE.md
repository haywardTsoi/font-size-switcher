# Font Size Switcher Plugin for Filament

一個為 Filament 管理面板提供字體大小切換功能的插件。

## 安裝

通過 Composer 安裝:

```bash
composer require solutionforest/font-size-switcher
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
                ->xs(0.8)
                ->md(1)
                ->lg(1.2),
        ]);
}
```

## 配置選項

### 基本用法

```php
FontSizeSwitcherPlugin::make()
    ->xs(0.8)      // 特小字體 (80%)
    ->sm(0.875)    // 小字體 (87.5%)
    ->md(1.0)      // 中等字體 (100% - 默認)
    ->lg(1.125)    // 大字體 (112.5%)
    ->xl(1.25)     // 特大字體 (125%)
```

### 自定義默認大小

```php
FontSizeSwitcherPlugin::make()
    ->xs(0.8)
    ->md(1)
    ->lg(1.2)
    ->defaultSize('md') // 設置默認字體大小
```

### 位置設置

```php
FontSizeSwitcherPlugin::make()
    ->position('right') // 'left' 或 'right'
```

### 顯示/隱藏控制

```php
FontSizeSwitcherPlugin::make()
    ->showInTopbar(true) // true 或 false
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

## 功能特點

- ✅ 響應式設計，適配桌面和移動設備
- ✅ 支持 Filament 的深色模式
- ✅ 自動保存用戶選擇的字體大小到 localStorage
- ✅ 支持自定義字體大小比例
- ✅ 集成到 Filament 頂部導航欄
- ✅ 易於配置和使用

## 瀏覽器支持

- Chrome/Edge: 最新版本
- Firefox: 最新版本  
- Safari: 最新版本

## 許可證

MIT 許可證。詳情請查看 [LICENSE](LICENSE.md) 文件。

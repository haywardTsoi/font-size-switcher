# Quick Start Guide

## 1. 安裝

```bash
composer require solutionforest/font-size-switcher
```

## 2. 註冊插件

在你的 `AdminPanelProvider.php` 中：

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

## 3. 完成！

字體大小切換器會自動出現在 Filament 頂部導航欄的右側。用戶可以點擊不同大小的 "A" 按鈕來調整字體大小。

## 常用配置

### 自定義字體大小範圍
```php
FontSizeSwitcherPlugin::make()
    ->xs(0.75)    // 75%
    ->sm(0.875)   // 87.5%
    ->md(1.0)     // 100% (默認)
    ->lg(1.125)   // 112.5%
    ->xl(1.25)    // 125%
```

### 設置默認字體大小
```php
FontSizeSwitcherPlugin::make()
    ->xs(0.8)->md(1)->lg(1.2)
    ->defaultSize('lg') // 默認使用大字體
```

### 自定義位置
```php
FontSizeSwitcherPlugin::make()
    ->xs(0.8)->md(1)->lg(1.2)
    ->position('left') // 顯示在左側
```

就是這麼簡單！🎉

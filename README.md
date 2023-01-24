# ph-Bookshelf

一个可以在单一站点上放一大堆文档的文档托管项目——我们把它称之为书架。

因为 web 相关的东西 Sukazyo 最熟悉的就是 php 了所以就用 php 写的。
但是写出来的代码还是十分离谱的不易读的：各种调用交错在一起，前后端也交错在一起

而且也并不好用，不好用到几乎没办法写教程...那种...至少现在如此。

有时间的话会补充的（en

<br/>

## 安装

下载/clone此仓库的内容，然后拖进 php 站点根目录即可。

### web-server 环境要求

- 支援 `.htaccess` 的 Webserver
  - 如果使用 Apache:
    - 启用模块 `rewrite`
      - 为网站根目录设置 `AllowOverride All`
  - 使用其它 Webserver，可以自行查询如何将 .htaccess 规则转换为你所使用的网站配置并写进你的网站配置当中
- PHP 版本 8.0 以上
  （旧版可能可以使用，但未经完全测试）
  - PHP 模块 `xml` (旧版可能叫做 `dom`)
  - PHP 模块 `mbstring`
  - composer 工具以安装项目依赖
  - 在 php.ini 中设置 `display_errors` 以及 `display_startup_errors` 为 `Off` (或者关闭 `E_WARNING` 及以下 log) <small>(这是由于最开始写代码极不上心导致很多地方都会有可能报出 warn，输出在屏幕上会导致很糟糕的使用体验)</small>

<br/>

### 使用

未来可能会拖出来一个示例之类的...

<br/>

## 开源许可

MIT License.

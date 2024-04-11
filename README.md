## 引言

1. [https://www.oschina.net/news/116992/xiunobbs-closed](https://www.oschina.net/news/116992/xiunobbs-closed  )  
2. [https://www.ithome.com/0/496/406.htm](https://www.ithome.com/0/496/406.htm)  
3. [https://tech.sina.com.cn/digi/2020-07-07/doc-iirczymm0954519.shtml](https://tech.sina.com.cn/digi/2020-07-07/doc-iirczymm0954519.shtml)  
4. [https://www.chinaz.com/2020/0707/1154797.shtml](https://www.chinaz.com/2020/0707/1154797.shtml)  

**国内知名开源 PHP 论坛“修罗 BBS”关闭，项目停止，作者出走开源**。2020-07-07中文各主流技术媒体版块都做了报道。

一石激起千层浪，修罗是我喜爱的产品，看到这个消息我第一时间去官方网站看了一下，果然关闭了。老黄这次走的太彻底，网站关闭，代码仓移除，连在看云上发布的两本xiunobbs开发电子书也都一并移除了。

 应该有不少像我一样，有项目在使用xiuno做二次开发，没有备份，又或者没有同步更新最新的安全补丁。

看到这个消息第一反应是找仓库做备份，gitee/github上面好多fork都是两年前的，本仓是我在github上找的，最新提交记录是2019-12-27，xiuno官方最后一次提交记录是2020-05-08，这中间有不少提交记录，可惜都不到了。

很幸运网上有人分享了截止到 2020-05-08 提交的源码包。把这个源码也一起合并到本仓库了。

## 原版内容

### 【Xiuno BBS 4.0 是什么？】

Xiuno BBS 4.0 是一款轻论坛产品，前端基于 BootStrap 4.0、JQuery 3，后端基于 PHP/7 MySQL XCache/Yac/Redis/Memcached...

自适应手机、平板、PC，有着非常方便的插件机制，不仅仅是一个轻论坛，还是一个良好的二次开发平台。

git： https://git.oschina.net/xiuno/xiunobbs.git

### 【Xiuno BBS 4.0 带来了什么？】

前端采用 BootStrap 4 + JQuery 3，响应式布局，自适应手机，平板，PC 设备，不再需要单独开发移动版本。

对 Bootstrap 4 进行了增强和兼容，比如增加 $('#submit').button('xxx').delay(3000).location('xxx.php') 的连续操作支持。

xiuno.js 采用了 xn. 命名空间，不再担心 js 命名冲突，完善了对常用的 php 函数的实现。

增加了通用的 $.each_sync() 方法，从客户端避免 ajax 并发导致的服务端并发写数据问题，简化了服务端逻辑。

不再支持 IE89 和以下版本，全面拥抱移动端，不用再用琢磨恶心的 css hack。

不再强制要求 URL-Rewrite， 采用相对路径的 URL 格式，方便部署到子目录：user-login.htm

图片缩略、裁切放到了客户端，不再依赖服务端 GD 库（不再担心各种 GD 漏洞和弱点）。

同时支持 Session 和 Token 方式登录，可以全站返回 json 数据，方便 APP 开发。

插件机制采用 hook + overwrite 方式，方便插入，和覆盖，非常方便二次开发，并且不影响性能，不影响编译。

db 层采用了更加方便的接口，可以同时支持 SQL 和 NoSQL 的方式操作数据（提倡 NoSQL)。

论坛功能上更加的精简，更多功能采用插件的方式进行扩充。

引入了语言包，自带简体、繁体、英文三个版本。

插件中心正式开启，开发者可以入驻，开发收费插件。

只需要一个博客插件，它就可以变成一个功能强大的博客。

帖子支持 txt html markdown 三种格式，自带适度整合的 UMEditor 插件，修正了 UM 在 Bootstrap 4 下的很多问题。

xiunophp 4.0 这个框架合并成了一个文件 xiunophp.min.php，只需要一个 include 就可以开始使用里面提供的方便的函数和全局变量。

Xiuno BBS 4 正式版经历了近 2 年，7 个 beta 版本，最终定型，这可能是最后一个大版本，放心动手二次开发吧。


### 【性能方面】

采用静态语言编程风格，充分发挥 PHP7 OPCache 的威力。

专门针对 BBS 业务的索引优化和适度的缓存。

大量的运算放到了客户端，并发问题尽量由客户端控制。

作者十多年从业经验带领您绕过雷区。

### 【授权】

Xiuno BBS 4.0 采用 MIT 协议发布，您可以自由修改、派生版本、商用而不用担心任何法律风险（修改后应保留原来的版权信息）。

我们承诺对主程序永远免费，在没有盈利前接受正派人士的捐赠。


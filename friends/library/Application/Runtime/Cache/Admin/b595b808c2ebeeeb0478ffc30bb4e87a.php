<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" charset="utf-8" content="text/css">
    <title>后台</title>
    <link rel="stylesheet" type="text/css" href="/passon/Public/css/Admin/header.css">
    <link rel="stylesheet" type="text/css" href="/passon/Public/css/Admin/index.css">
    <script type="text/javascript" src="/passon/Public/js/jquery-1.11.1.min.js"></script>
</head>
<body>
<div class="header">
    <div class="header-title">
        <span class="header-title-m">
            <span class="header-big">M</span>
            <span class="header-title-top">AKERWAY</span>
            <span class="header-title-bottom">一起分享智慧</span>
        </span>
    </div>
    <div class="header-ul">
        <ul>
            <li>首页</li>
            <li>用户管理</li>
            <li>书籍管理</li>
            <li>统计分析
                <ul class="sta">
                    <li>用户分析</li>
                    <li>书籍分析</li>
                </ul>
            </li>
        </ul>
    </div>
    <div class="header-username">
        <img src="/passon/Public/images/basketball.jpg"/>
        <ul>
            <li>管理员</li>
            <li>
                <a href="<?php echo U(logout);?>">注销</a>
            </li>
        </ul>
    </div>
 </div>
<div class="content">
    <div class="homepage">
        <div class="homepage-title">
            <ul>
                <li>
                    <div class="homepage-number">200</div>
                    <div>总用户数</div>
                    <div>1234</div>
                </li>
                <li>
                    <div class="homepage-number">200</div>
                    <div>总书籍数</div>
                    <div>1234</div>
                </li>
                <li class="homepage-right">
                    <div class="homepage-number">200</div>
                    <div>总流通书籍数</div>
                    <div>1234</div>
                </li>
            </ul>
        </div>
        <div class="homepage-body">
            <div>管&nbsp;理&nbsp;员&nbsp;操&nbsp;作&nbsp;日&nbsp;志</div>
            <ul>
                <li>
                    <span>用户</span>
                    <span>行为</span>
                    <span class="home-details">详情</span>
                    <span>时间</span>
                    <span>操作</span>
                </li>
                <li>
                    <span>史欣璐</span>
                    <span>修改</span>
                    <span class="home-details">修改了用户ABC的电话</span>
                    <span>2016年4月</span>
                    <span class="home-color">恢复数据</span>
                </li>
                <li>
                    <span>史欣璐</span>
                    <span>修改</span>
                    <span class="home-details">修改了用户ABC的电话</span>
                    <span>2016年4月</span>
                    <span class="home-color">恢复数据</span>
                </li>
            </ul>
        </div>
    </div>
    <div class="useradmin">2</div>
    <div class="bookadmin">3</div>
    <div class="statistics">
        <div class="user-statistics">
            <ul>
                <li>用户数据</li>
                <li>用户属性</li>
            </ul>
            <div class="user-statistics-body">
                <div class="user-statistics-navigator">
                    <ul>
                        <li>总用户数</li>
                        <li>新增用户数</li>
                        <li>日活跃用户数</li>
                        <li class="navigator-last">总活跃用户数</li>
                    </ul>
                    <div class="user-statistics-message">
                        <div style="display: block">
                            <div class="chart">
                                <div class="chart-time">时间选择</div>
                                <div class="chart-chart"></div>
                            </div>
                            <div class="data">
                                <div class="data-title">
                                    <span>时间选择</span>
                                    <input  type="button" value="下载数据"/>
                                </div>
                                <table border="1">
                                    <tr>
                                        <th>时间</th>
                                        <th>新增用户</th>
                                        <th>日活跃用户</th>
                                        <th>总用户</th>
                                        <th>日活跃率</th>
                                    </tr>
                                    <tr>
                                        <td>2016.04.11</td>
                                        <td>50</td>
                                        <td>70</td>
                                        <td>100</td>
                                        <td>70%</td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                        <div>
                            <div class="chart">
                                <div class="chart-time">时间选择</div>
                                <div class="chart-chart"></div>
                            </div>
                            <div class="data">
                                <div class="data-title">
                                    <span>时间选择</span>
                                    <input  type="button" value="下载数据"/>
                                </div>
                                <table border="1">
                                    <tr>
                                        <th>时间</th>
                                        <th>新增用户</th>
                                        <th>日活跃用户</th>
                                        <th>总用户</th>
                                        <th>日活跃率</th>
                                    </tr>
                                    <tr>
                                        <td>2016.04.11</td>
                                        <td>50</td>
                                        <td>70</td>
                                        <td>100</td>
                                        <td>70%</td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                        <div>
                            <div class="chart">
                                <div class="chart-time">时间选择</div>
                                <div class="chart-chart"></div>
                            </div>
                            <div class="data">
                                <div class="data-title">
                                    <span>时间选择</span>
                                    <input  type="button" value="下载数据"/>
                                </div>
                                <table border="1">
                                    <tr>
                                        <th>时间</th>
                                        <th>新增用户</th>
                                        <th>日活跃用户</th>
                                        <th>总用户</th>
                                        <th>日活跃率</th>
                                    </tr>
                                    <tr>
                                        <td>2016.04.11</td>
                                        <td>50</td>
                                        <td>70</td>
                                        <td>100</td>
                                        <td>70%</td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                        <div>
                            <div class="chart">
                                <div class="chart-time">时间选择</div>
                                <div class="chart-chart"></div>
                            </div>
                            <div class="data">
                                <div class="data-title">
                                    <span>时间选择</span>
                                    <input  type="button" value="下载数据"/>
                                </div>
                                <table border="1">
                                    <tr>
                                        <th>时间</th>
                                        <th>新增用户</th>
                                        <th>日活跃用户</th>
                                        <th>总用户</th>
                                        <th>日活跃率</th>
                                    </tr>
                                    <tr>
                                        <td>2016.04.11</td>
                                        <td>50</td>
                                        <td>70</td>
                                        <td>100</td>
                                        <td>70%</td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div></div>
            </div>
        </div>
        <div class="book-statistics">
            <ul>
                <li>书籍数据</li>
                <li>书籍属性</li>
            </ul>
            <div class="book-statistics-body">
                <div class="book-statistics-navigator">
                    <ul>
                        <li>总书籍数</li>
                        <li>新增书籍数</li>
                        <li>日活跃书籍数</li>
                        <li class="navigator-last">总活跃书籍数</li>
                    </ul>
                    <div class="book-statistics-message">
                        <div style="display: block">
                            <div class="chart">
                                <div class="chart-time">时间选择</div>
                                <div class="chart-chart"></div>
                            </div>
                            <div class="data">
                                <div class="data-title">
                                    <span>时间选择</span>
                                    <input  type="button" value="下载数据"/>
                                </div>
                                <table border="1">
                                    <tr>
                                        <th>时间</th>
                                        <th>新增书籍</th>
                                        <th>日流通书籍</th>
                                        <th>总书籍</th>
                                        <th>日活跃率</th>
                                    </tr>
                                    <tr>
                                        <td>2016.04.11</td>
                                        <td>50</td>
                                        <td>70</td>
                                        <td>100</td>
                                        <td>70%</td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                        <div>
                            <div class="chart">
                                <div class="chart-time">时间选择</div>
                                <div class="chart-chart"></div>
                            </div>
                            <div class="data">
                                <div class="data-title">
                                    <span>时间选择</span>
                                    <input  type="button" value="下载数据"/>
                                </div>
                                <table border="1">
                                    <tr>
                                        <th>时间</th>
                                        <th>新增书籍</th>
                                        <th>日流通书籍</th>
                                        <th>总书籍</th>
                                        <th>日活跃率</th>
                                    </tr>
                                    <tr>
                                        <td>2016.04.11</td>
                                        <td>50</td>
                                        <td>70</td>
                                        <td>100</td>
                                        <td>70%</td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                        <div>
                            <div class="chart">
                                <div class="chart-time">时间选择</div>
                                <div class="chart-chart"></div>
                            </div>
                            <div class="data">
                                <div class="data-title">
                                    <span>时间选择</span>
                                    <input  type="button" value="下载数据"/>
                                </div>
                                <table border="1">
                                    <tr>
                                        <th>时间</th>
                                        <th>新增书籍</th>
                                        <th>日流通书籍</th>
                                        <th>总书籍</th>
                                        <th>日活书籍</th>
                                    </tr>
                                    <tr>
                                        <td>2016.04.11</td>
                                        <td>50</td>
                                        <td>70</td>
                                        <td>100</td>
                                        <td>70%</td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                        <div>
                            <div class="chart">
                                <div class="chart-time">时间选择</div>
                                <div class="chart-chart"></div>
                            </div>
                            <div class="data">
                                <div class="data-title">
                                    <span>时间选择</span>
                                    <input  type="button" value="下载数据"/>
                                </div>
                                <table border="1">
                                    <tr>
                                        <th>时间</th>
                                        <th>新增书籍</th>
                                        <th>日流通书籍</th>
                                        <th>总书籍</th>
                                        <th>日活跃率</th>
                                    </tr>
                                    <tr>
                                        <td>2016.04.11</td>
                                        <td>50</td>
                                        <td>70</td>
                                        <td>100</td>
                                        <td>70%</td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div></div>
            </div>
        </div>
    </div>
</div>
</body>
<script type="text/javascript" src="/passon/Public/js/Admin/index.js"></script>
</html>
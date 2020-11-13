/**
 * Created by Bless on 2017/4/17.
 */
(function() {
    tinymce.PluginManager.add('my_mce_button', function( editor, url ) {
        editor.addButton( 'my_mce_button', {
            text: '项目模板',
            title: "选择项目模板", //    鼠标放在按钮上时的提示文字
            icon: false,
            type: 'menubutton',
            menu: [
                {
                    text: '创新项目模板',
                    onclick: function () {
                        editor.windowManager.open({
                            title: '创新项目模板',
                            width: 400, //    对话框宽度
                            height: 350, //    对话框高度
                            body:[
                                {
                                    type   : 'container',
                                    name   : '硬件项目',
                                    html  : '<p style="font-size:15px;">目标<br/><br/>原理<br/><br/>设备<br/><br/>硬件组装<br/><br/>功能实现<br/><br/>项目演示<br/><br/>团队进度<br/><br/>团队故事<br/><br/>资料链接<br/><br/><p>'
                                }
                            ],

                            onsubmit: function () {
                                editor.insertContent(
                                    '<h2><strong>目标</strong></h2>' +
                                    '阐述项目想要实现的效果。' +
                                    '<h2><strong>原理</strong></h2>' +
                                    '阐述项目想实现的功能模块，并用原理图的形式表达，例如：' +
                                    '<h2><strong>设备</strong></h2>' +
                                    '<table style="height: 158px; width: 460px; border-color: #d8d8d8; background-color: #f9f9f9;" border="1px" cellspacing="0" cellpadding="5px">'+
                                    '<tbody>'+
                                    '<tr>'+
                                    '<td style="width: 225px;"><strong>模块</strong></td>'+
                                    '<td style="width: 57px; text-align: center;"><strong>数量</strong></td>'+
                                    '<td style="width: 171px;"><strong>功能</strong></td>'+
                                    '</tr>'+
                                    '<tr>'+
                                    '<td style="width: 225px;">mCookie-Core+</td>'+
                                    '<td style="width: 57px; text-align: center;">1</td>'+
                                    '<td style="width: 171px;">核心板</td>'+
                                    '</tr>'+
                                    '<tr>'+
                                    '<td style="width: 225px;">mCookie-Hub</td>'+
                                    '<td style="width: 57px; text-align: center;">1</td>'+
                                    '<td style="width: 171px;">传感器转接板</td>'+
                                    '</tr>'+
                                    '<tr>'+
                                    '<td style="width: 225px;">mCookie-Hub</td>'+
                                    '<td style="width: 57px; text-align: center;">1</td>'+
                                    '<td style="width: 171px;">传感器转接板</td>'+
                                    '</tr>'+
                                    '</tbody>'+
                                    '</table>'+
                                    '<h2><strong>硬件组装</strong></h2>' +
                                    '利用效果图或拍摄图片清晰表现硬件组装图。' +
                                    '<h2><strong>功能实现</strong></h2>' +
                                    '<ul>' +
                                    '<li>解读每个功能模块的实现过程，并讲解一下重要部分的代码。</li>' +
                                    '<li>项目源码可托管在github上，并在此放源码链接。</li>' +
                                    '<li>一个优秀的开源项目，源码一定有丰富的注释，让后人易读且方便修改。</li>' +
                                    '</ul>' +
                                    '<h2><strong>项目演示</strong></h2>' +
                                    '<ul>' +
                                    '<li>项目演示可放视频链接或二维码，推荐腾讯视频哦，适合在微信里传播。</li>' +
                                    '<li>web类项目，可以利用github的项目演示功能，创建在线链接，方法参照：<a href="http://www.tuicool.com/articles/Z7nMva" target="_blank">如何在github上创建个人项目的在线演示demo</a></li>' +
                                    '</ul>' +
                                    '<h2><strong>团队进度</strong></h2>' +
                                    '<table style="height: 180px; border-color: #d8d8d8; background-color: #f9f9f9; width: 454px;" border="1" cellspacing="0" cellpadding="5px">'+
                                    '<tbody>'+
                                    '<tr>'+
                                    '<td style="width: 112px;">姓名</td>'+
                                    '<td style="width: 234px;">团队分工</td>'+
                                    '<td style="width: 133px;">进度（见说明）</td>'+
                                    '</tr>'+
                                    '<tr>'+
                                    '<td style="width: 112px;">张科科</td>'+
                                    '<td style="width: 234px;">技术担当，资源协调</td>'+
                                    '<td style="width: 133px;"> 1</td>'+
                                    ' </tr>'+
                                    ' <tr>'+
                                    '<td style="width: 112px;">王蛋蛋</td>'+
                                    '<td style="width: 234px;">硬件设计，创意思路</td>'+
                                    '<td style="width: 133px;"> 1</td>'+
                                    '</tr>'+
                                    '<tr>'+
                                    '<td style="width: 112px;">李华华</td>'+
                                    '<td style="width: 234px;">程序调试，bug消灭者</td>'+
                                    '<td style="width: 133px;"> 1</td>'+
                                    '</tr>'+
                                    '<tr>'+
                                    '<td style="width: 112px;">韩梅梅</td>'+
                                    '<td style="width: 234px;">海报制作，文档撰写</td>'+
                                    '<td style="width: 133px;"> 1</td>'+
                                    '</tr>'+
                                    '</tbody>'+
                                    '</table>'+
                                    '说明：进度分为5档，其中1表示：还未开始；2表示：刚开始进行；3表示：正在进行；4表示：接近完成；5表示：已完成。请在每次更新时，由项目组长在进度一栏根据组员完成情况填写对应数字。'+
                                    '<h2><strong>团队故事</strong></h2>'+
                                    '团队联系方式：邮箱、QQ、电话等；'+
                                    '团队合作过程中发生的趣事、攻克的难关。'+
                                    '<h2><strong>资料链接</strong></h2>'+
                                    '<a href="http://www.w3school.com.cn/" target="_blank"><em>w3s</em>chool 在线教程</a>');
                            }
                        });
                    }
                },
                {
                    text: '创新项目模版（新）',
                    onclick: function () {
                        editor.windowManager.open({
                            title: '创新项目模版（新）',
                            width: 400, //    对话框宽度
                            height: 400, //    对话框高度
                            body:[
                                {
                                    type   : 'container',
                                    name   : '创新项目模版（新）',
                                    html  : '<p style="font-size:15px;">简介<br/><br/>创意过程<br/><br/>用户分析<br/><br/>场景分析<br/><br/>系统功能拆解<br/><br/>功能实现<br/><br/>项目演示<br/><br/>团队介绍<br/><br/>团队故事<br/><p>'
                                }
                            ],

                            onsubmit: function () {
                                editor.insertContent(
                                    '<h2>简介</h2>'+
                                    '<span style="color: #ff0000;">一句话show出你们的小程序。总述小程序想要解决的问题、实现的效果。</span>' +
                                    '<h2>创意过程</h2>'+
                                    '<ul>'+
                                    '<li>疯狂八分钟：<span style="color: #ff0000;">（请罗列小组所有成员的创意点）</span></li>' +
                                    '<li>四象限法：<span style="color: #ff0000;">（请添加小组的四象限图，拍照或截图。为了保证图片能被正常查看，请务必通过上方工具栏左上角的“添加媒体”来插入图片。请保证图片清晰哦）</span></li>' +
                                    '</ul>' +
                                    '<h2>用户分析</h2>' +
                                    '<ul>' +
                                    '<li>目标用户：<span style="color: #ff0000;">（请文字描述）</span></li>' +
                                    '<li>用户画像：<span style="color: #ff0000;">（请添加用户画像图片。为了保证图片能被正常查看，请务必通过上方工具栏左上角的“添加媒体”来插入图片。请保证图片清晰哦）</span></li>' +
                                    '<li>痛点——需求点：根据用户特点的分析，归纳一下目标用户的痛点和相对应的需求。</li>' +
                                    '</ul>' +
                                    '<table style="border-color: #616161; width: 814px;" border="1px">' +
                                    '<tbody>' +
                                    '<tr>' +
                                    '<td style="width: 404.6875px;">' +
                                    '<p style="text-align: center;">痛点</p>' +
                                    '</td>' +
                                    '<td style="width: 400.3125px;">' +
                                    '<p style="text-align: center;">需求点</p>' +
                                    '</td>'+
                                    '</tr>'+
                                    '<tr>'+
                                    '<td style="width: 404.6875px;"></td>'+
                                    '<td style="width: 400.3125px;"></td>'+
                                    '</tr>'+
                                    '<tr>'+
                                    '<td style="width: 404.6875px;"></td>'+
                                    '<td style="width: 400.3125px;"></td>'+
                                    '</tr>'+
                                    '<tr>'+
                                    '<td style="width: 404.6875px;"></td>'+
                                    '<td style="width: 400.3125px;"></td>'+
                                    '</tr>'+
                                    '<tr>'+
                                    '<td style="width: 404.6875px;"></td>'+
                                    '<td style="width: 400.3125px;"></td>'+
                                    '</tr>'+
                                    '</tbody>'+
                                    '</table>'+
                                    '&nbsp;'+
                                    '<h2>场景分析</h2>'+
                                    '目标用户的使用路径可能是这样的：'+
                                    '<span style="color: #ff0000;">（请添加用户旅程图图片。为了保证图片能被正常查看，请务必通过上方工具栏左上角的“添加媒体”来插入图片。请保证图片清晰哦）</span>'+
                                    '&nbsp;'+
                                    '<h2>系统功能拆解</h2>'+
                                    '请根据组件认知与系统功能拆解，完成小组创意小程序的核心功能实现的技术分析：'+
                                    '<table style="border-color: #5e5e5e; width: 803px;" border="1px">'+
                                    '<tbody>'+
                                    '<tr>'+
                                    '<td style="width: 395.140625px;">'+
                                    '<p style="text-align: center;">小程序核心功能</p>'+
                                    '</td>'+
                                    '<td style="width: 396.859375px;">'+
                                    '<p style="text-align: center;">技术模块</p>'+
                                    '</td>'+
                                    '</tr>'+
                                    '<tr>'+
                                    '<td style="width: 395.140625px; text-align: center;"><span style="color: #ff0000;"> 功能1</span></td>'+
                                    '<td style="width: 396.859375px; text-align: center;"><span style="color: #ff0000;"> 功能1对应的组件</span></td>'+
                                    '</tr>'+
                                    '<tr>'+
                                    '<td style="width: 395.140625px; text-align: center;"><span style="color: #ff0000;"> 功能2</span></td>'+
                                    '<td style="width: 396.859375px; text-align: center;"><span style="color: #ff0000;"> 功能2对应的组件</span></td>'+
                                    '</tr>'+
                                    '<tr>'+
                                    '<td style="width: 395.140625px;"></td>'+
                                    '<td style="width: 396.859375px;"></td>'+
                                    '</tr>'+
                                    '<tr>'+
                                    '<td style="width: 395.140625px;"></td>'+
                                    '<td style="width: 396.859375px;"></td>'+
                                    '</tr>'+
                                    '</tbody>'+
                                    '</table>'+
                                    '<strong> </strong>'+
                                    '<h2>功能实现</h2>'+
                                    '<span style="color: #ff0000;">解读每个功能模块的实现过程，并讲解一下重要部分的代码。</span>'+
                                    '&nbsp;'+
                                    '<h2>项目演示</h2>'+
                                    '<span style="color: #ff0000;">通过“添加媒体”上传PPT</span>'+
                                    '&nbsp;'+
                                    '<h2><strong>团队介绍</strong></h2>'+
                                    '<table style="height: 180px; border-color: #616161; width: 454px;" border="1px" width="454">'+
                                    '<tbody>'+
                                    '<tr>'+
                                    '<td style="width: 142.15625px; text-align: center;">姓名</td>'+
                                    '<td style="width: 295.859375px; text-align: center;">团队分工</td>'+
                                    '</tr>'+
                                    '<tr>'+
                                    '<td style="width: 142.15625px; text-align: center;">张科科</td>'+
                                    '<td style="width: 295.859375px; text-align: center;"><span style="color: #ff0000;">（均为示例，可修改）</span>'+
                                    '<span style="color: #ff0000;">队长，组织协调进度</span></td>'+
                                    '</tr>'+
                                    '<tr>'+
                                    '<td style="width: 142.15625px; text-align: center;">王蛋蛋</td>'+
                                    '<td style="width: 295.859375px; text-align: center;"><span style="color: #ff0000;">技术担当，资源协调</span></td>'+
                                    '</tr>'+
                                    '<tr>'+
                                    '<td style="width: 142.15625px; text-align: center;">李华华</td>'+
                                    '<td style="width: 295.859375px; text-align: center;"><span style="color: #ff0000;">ppt制作</span></td>'+
                                    '</tr>'+
                                    '<tr>'+
                                    '<td style="width: 142.15625px; text-align: center;">韩梅梅</td>'+
                                    '<td style="width: 295.859375px; text-align: center;">'+
                                    '<p style="text-align: center;"><span style="color: #ff0000;">海报制作，文档撰写</span></p>'+
                                    '</td>'+
                                    '</tr>'+
                                    '</tbody>'+
                                    '</table>'+
                                    '&nbsp;'+
                                    '<h2>团队故事</h2>'+
                                    '<span style="color: #ff0000;">团队合作过程中发生的趣事、攻克的难关等。</span>'+
                                    '&nbsp;'+
                                    '<h2><strong>参考资料</strong></h2>'+
                                    '<span style="color: #ff0000;">完成项目时，参考了哪些学习资料？请附上链接，相信你提供的资源能为其他初学者带来很大的帮助！</span>'+
                                    '&nbsp;'+
                                    '&nbsp;'
                                );
                            }
                        });
                    }
                },
                {
                    text: '硬件项目',
                    onclick: function () {
                        editor.windowManager.open({
                            title: '硬件项目',
                            width: 400, //    对话框宽度
                            height: 350, //    对话框高度
                            body:[
                                {
                                    type   : 'container',
                                    name   : '硬件项目',
                                    html  : '<p style="font-size:15px;">目标<br/><br/>原理<br/><br/>设备<br/><br/>硬件组装<br/><br/>功能实现<br/><br/>项目演示<br/><br/>团队故事<br/><br/>资料链接<br/><br/><p>'
                                }
                            ],

                            onsubmit: function () {
                                editor.insertContent(
                                    '<h2><strong>目标</strong></h2>' +
                                    '阐述项目想要实现的效果。' +
                                    '<h2><strong>原理</strong></h2>' +
                                    '阐述项目想实现的功能模块，并用原理图的形式表达，例如：' +
                                    '<h2><strong>设备</strong></h2>' +
                                    '<table style="height: 158px; width: 460px; border-color: #d8d8d8; background-color: #f9f9f9;" border="1px" cellspacing="0" cellpadding="5px">'+
                                    '<tbody>'+
                                    '<tr>'+
                                    '<td style="width: 225px;"><strong>模块</strong></td>'+
                                    '<td style="width: 57px; text-align: center;"><strong>数量</strong></td>'+
                                    '<td style="width: 171px;"><strong>功能</strong></td>'+
                                    '</tr>'+
                                    '<tr>'+
                                    '<td style="width: 225px;">mCookie-Core+</td>'+
                                    '<td style="width: 57px; text-align: center;">1</td>'+
                                    '<td style="width: 171px;">核心板</td>'+
                                    '</tr>'+
                                    '<tr>'+
                                    '<td style="width: 225px;">mCookie-Hub</td>'+
                                    '<td style="width: 57px; text-align: center;">1</td>'+
                                    '<td style="width: 171px;">传感器转接板</td>'+
                                    '</tr>'+
                                    '<tr>'+
                                    '<td style="width: 225px;">mCookie-Hub</td>'+
                                    '<td style="width: 57px; text-align: center;">1</td>'+
                                    '<td style="width: 171px;">传感器转接板</td>'+
                                    '</tr>'+
                                    '</tbody>'+
                                    '</table>'+
                                    '<h2><strong>硬件组装</strong></h2>' +
                                    '利用效果图或拍摄图片清晰表现硬件组装图。' +
                                    '<h2><strong>功能实现</strong></h2>' +
                                    '<ul>' +
                                    '<li>解读每个功能模块的实现过程，并讲解一下重要部分的代码。</li>' +
                                    '<li>项目源码可托管在github上，并在此放源码链接。</li>' +
                                    '<li>一个优秀的开源项目，源码一定有丰富的注释，让后人易读且方便修改。</li>' +
                                    '</ul>' +
                                    '<h2><strong>项目演示</strong></h2>' +
                                    '<ul>' +
                                    '<li>项目演示可放视频链接或二维码，推荐腾讯视频哦，适合在微信里传播。</li>' +
                                    '<li>web类项目，可以利用github的项目演示功能，创建在线链接，方法参照：<a href="http://www.tuicool.com/articles/Z7nMva" target="_blank">如何在github上创建个人项目的在线演示demo</a></li>' +
                                    '</ul>' +
                                    '<h2><strong>团队故事</strong></h2>' +
                                    '<table style="height: 180px; border-color: #d8d8d8; background-color: #f9f9f9; width: 454px;" border="1" cellspacing="0" cellpadding="5px">'+
                                    '<tbody>'+
                                    '<tr style="height: 24px;">'+
                                    '<td style="width: 80px; height: 24px;"><strong>姓名</strong></td>'+
                                    '<td style="width: 289px; height: 24px;"><strong>职责</strong></td>'+
                                    '</tr>'+
                                    '<tr style="height: 24px;">'+
                                    '<td style="width:80px; height: 24px;">张科科</td>'+
                                    '<td style="width: 289px; height: 24px;">技术担当，资源协调</td>'+
                                    '</tr>'+
                                    '<tr style="height: 24px;">'+
                                    '<td style="width: 80px; height: 24px;">王蛋蛋</td>'+
                                    '<td style="width: 289px; height: 24px;">硬件设计，创意思路</td>'+
                                    '</tr>'+
                                    '<tr style="height: 24px;">'+
                                    '<td style="width: 80px; height: 24px;">李华华</td>'+
                                    '<td style="width: 289px; height: 24px;">程序调试，bug消灭者</td>'+
                                    '</tr>'+
                                    '<tr style="height: 24px;">'+
                                    '<td style="width: 80px; height: 24px;">韩梅梅</td>'+
                                    '<td style="width: 289px; height: 24px;">海报制作，文档撰写</td>'+
                                    '</tr>'+
                                    '</tbody>'+
                                    '</table>'+
                                    '团队联系方式：邮箱、QQ、电话等；<br>团队合作过程中发生的趣事、攻克的难关。'+
                                    '<h2><strong>资料链接</strong></h2>' +
                                    '<a href="http://www.w3school.com.cn/" target="_blank"><em>w3s</em>chool 在线教程</a>');
                            }
                        });
                    }
                },
                {
                    text: 'WEB项目',
                    onclick: function() {
                        editor.windowManager.open( {
                            title: 'WEB项目',
                            width: 400, //    对话框宽度
                            height: 350, //    对话框高度
                            body:[
                                {
                                    type   : 'container',
                                    name   : 'WEB项目',
                                    html  :  '<p style="font-size:15px;">需求分析<br/><br/>目标<br/><br/>总体设计<br/><br/>详细设计<br/><br/>功能实现<br/><br/>项目演示<br/><br/>团队故事<br/><br/>资料链接<br/><br/><p>'
                                }
                            ],
                            onsubmit: function(  ) {
                                editor.insertContent(
                                    '<h2><strong>需求分析</strong></h2>' +
                                    '<ol>' +
                                    '<li><p class="reader-word-layer reader-word-s1-1">业务分析</p></li>' +
                                    '<li><p class="reader-word-layer reader-word-s1-1">用户分析</p></li>' +
                                    '<li><p class="reader-word-layer reader-word-s1-1">功能分析</p></li>' +
                                    '<li><p class="reader-word-layer reader-word-s1-1">性能分析</p></li>' +
                                    '</ol>' +
                                    '<h2><strong>目标</strong></h2>' +
                                    '<ol>' +
                                    '<li><p class="reader-word-layer reader-word-s3-15">基本要求：需要包括的主要功能</p></li>' +
                                    '<li><p class="reader-word-layer reader-word-s3-15">开发目标：预期的展现形式</p></li>' +
                                    '<li><p class="reader-word-layer reader-word-s3-15">应用目标：计划的应用效果</p></li>' +
                                    '</ol>' +
                                    '<h2><strong>总体设计</strong></h2>' +
                                    '系统业务流程及描述（可以流程图的方式呈现）' +
                                    '<h2><strong>详细设计</strong></h2>' +
                                    '系统各个功能模块界面展示' +
                                    '<h2><strong>功能实现</strong></h2>' +
                                    '<ul>' +
                                    '<li>具体文件结构</li>' +
                                    '<li>解读每个功能模块的实现过程，并讲解一下重要部分的代码。</li>' +
                                    '<li>项目源码可托管在github上，并在此放源码链接。</li>' +
                                    '<li>一个优秀的开源项目，源码一定有丰富的注释，让后人易读且方便修改。</li>' +
                                    '</ul>' +
                                    '<h2><strong>项目演示</strong></h2>' +
                                    '<ul>' +
                                    '<li>项目演示可放视频链接或二维码，推荐腾讯视频哦，适合在微信里传播。</li>' +
                                    '<li>web类项目，可以利用github的项目演示功能，创建在线链接，方法参照：<a href="http://www.tuicool.com/articles/Z7nMva" target="_blank">如何在github上创建个人项目的在线演示demo</a></li>' +
                                    '</ul>' +
                                    '<h2><strong>团队故事</strong></h2>' +
                                    '<table style="height: 180px; border-color: #d8d8d8; background-color: #f9f9f9; width: 454px;" border="1" cellspacing="0" cellpadding="5px">'+
                                    '<tbody>'+
                                    '<tr style="height: 24px;">'+
                                    '<td style="width: 80px; height: 24px;"><strong>姓名</strong></td>'+
                                    '<td style="width: 289px; height: 24px;"><strong>职责</strong></td>'+
                                    '</tr>'+
                                    '<tr style="height: 24px;">'+
                                    '<td style="width:80px; height: 24px;">张科科</td>'+
                                    '<td style="width: 289px; height: 24px;">技术担当，资源协调</td>'+
                                    '</tr>'+
                                    '<tr style="height: 24px;">'+
                                    '<td style="width: 80px; height: 24px;">王蛋蛋</td>'+
                                    '<td style="width: 289px; height: 24px;">硬件设计，创意思路</td>'+
                                    '</tr>'+
                                    '<tr style="height: 24px;">'+
                                    '<td style="width: 80px; height: 24px;">李华华</td>'+
                                    '<td style="width: 289px; height: 24px;">程序调试，bug消灭者</td>'+
                                    '</tr>'+
                                    '<tr style="height: 24px;">'+
                                    '<td style="width: 80px; height: 24px;">韩梅梅</td>'+
                                    '<td style="width: 289px; height: 24px;">海报制作，文档撰写</td>'+
                                    '</tr>'+
                                    '</tbody>'+
                                    '</table>'+
                                    '团队联系方式：邮箱、QQ、电话等；<br>团队合作过程中发生的趣事、攻克的难关。'+
                                    '<h2><strong>资料链接</strong></h2>' +
                                    '<a href="http://www.w3school.com.cn/" target="_blank"><em>w3s</em>chool 在线教程</a>'
                                );
                            }
                        });
                    }
                },
                {
                    text: '教程案例',
                    onclick: function() {
                        editor.windowManager.open( {
                            title: '教程案例',
                            width: 400, //    对话框宽度
                            height: 350, //    对话框高度
                            body:[
                                {
                                    type   : 'container',
                                    name   : '教程案例',
                                    html  :  '<p style="font-size:15px;">目标<br/><br/>知识点<br/><br/>设备<br/><br/>硬件组装<br/><br/>功能实现<br/><br/>案例演示<br/><br/>思考及扩展应用<br/><br/><p>'
                                }
                            ],
                            onsubmit: function(  ) {
                                editor.insertContent(
                                    '<h2><strong>目标</strong></h2>' +
                                    '阐述教程想要实现的效果。' +
                                    '<h2><strong>知识点</strong></h2>' +
                                    '<ul>' +
                                    '<li>阐述教程涉及的重难点</li>' +
                                    '<li>阐述教程涉及的重难点</li>' +
                                    '<li>阐述教程涉及的重难点</li>' +
                                    '</ul>' +
                                    '<h2><strong>设备</strong></h2>' +
                                    '<table style="height: 158px; width: 460px; border-color: #d8d8d8; background-color: #f9f9f9;" border="1px" cellspacing="0" cellpadding="5px">'+
                                    '<tbody>'+
                                    '<tr>'+
                                    '<td style="width: 225px;"><strong>模块</strong></td>'+
                                    '<td style="width: 57px; text-align: center;"><strong>数量</strong></td>'+
                                    '<td style="width: 171px;"><strong>功能</strong></td>'+
                                    '</tr>'+
                                    '<tr>'+
                                    '<td style="width: 225px;">mCookie-Core+</td>'+
                                    '<td style="width: 57px; text-align: center;">1</td>'+
                                    '<td style="width: 171px;">核心板</td>'+
                                    '</tr>'+
                                    '<tr>'+
                                    '<td style="width: 225px;">mCookie-Hub</td>'+
                                    '<td style="width: 57px; text-align: center;">1</td>'+
                                    '<td style="width: 171px;">传感器转接板</td>'+
                                    '</tr>' +
                                    '</tbody>' +
                                    '</table>' +
                                    '<h2><strong>硬件组装</strong></h2>' +
                                    '利用效果图或拍摄图片清晰表现硬件组装图。' +
                                    '<h2><strong>功能实现</strong></h2>' +
                                    '<ul>' +
                                    '<li>解读每个功能模块的实现过程，并讲解一下重要部分的代码。</li>' +
                                    '<li>项目源码可托管在github上，并在此放源码链接。</li>' +
                                    '<li>一个优秀的开源项目，源码一定有丰富的注释，让后人易读且方便修改。</li>' +
                                    '</ul>' +
                                    '<h2><strong>案例演示</strong></h2>' +
                                    '<ul>' +
                                    '<li>案例演示可放视频链接或二维码，推荐腾讯视频哦，适合在微信里传播。</li>' +
                                    '<li>web类案例，可以利用github的演示功能，创建在线链接，方法参照：<a href="http://www.tuicool.com/articles/Z7nMva" target="_blank">如何在github上创建个人项目的在线演示demo</a></li>' +
                                    '</ul>' +
                                    '<h2><strong>思考及扩展应用</strong></h2>' +
                                    '<ul>' +
                                    '<li>提出案例中涉及到的更有深度的问题供大家思考</li>' +
                                    '<li>教程可应用的其他范围</li>' +
                                    '</ul>'
                                );
                            }
                        });
                    }
                },
                {
                    text: 'QA模板',
                    onclick: function() {
                        editor.windowManager.open( {
                            title: 'QA模板',
                            width: 400, //    对话框宽度
                            height: 350, //    对话框高度
                            body:[
                                {
                                    type   : 'container',
                                    name   : 'QA模板',
                                    html  :  '<p style="font-size:15px;">问题描述<br/><br/>解决方案<br/><br/>原理性理解<br/><br/>探索故事<br/><br/><p>'
                                }
                            ],
                            onsubmit: function(  ) {
                                editor.insertContent(
                                    '<h2></h2>' +
                                    '<h2><strong>问题描述（Q）</strong></h2>' +
                                    '阐述所遇到的问题。运用文字、截图等等，将问题描述得尽量清楚。' +
                                    '<h2><strong>解决方案（A）</strong></h2>' +
                                    '阐述自己如何解决的问题。讲解清楚步骤。和上面一样，要求图文并茂。' +
                                    '<h2><strong>原理性理解</strong></h2>' +
                                    '如果有的话，对遇到的问题进行一些分析，将问题所涉及到的知识背景进行一些表述和介绍。' +
                                    '<h2><strong>探索故事</strong></h2>' +
                                    '在导论课中，同学会遇到很多新知识新问题。分享一些调试方法、学习方法的心得体会，或许会对其他同学也产生很多的启发。'+
                                    '<hr>'+
                                    '<p>提交方法：</p>'+
                                    '编写完QA以后，将QA的网页链接（即URL）发给机器人，不需要报学号姓名等等其他的文字信息。'+
                                    '&nbsp;'+
                                    '&nbsp;'+
                                    '&nbsp;'
                                );
                            }
                        });
                    }
                },
                {
                    text: '智惠乡村项目模板',
                    onclick: function () {
                        editor.windowManager.open({
                            title: '智惠乡村项目模板',
                            width: 400, //    对话框宽度
                            height: 350, //    对话框高度
                            body:[
                                {
                                    type   : 'container',
                                    name   : '智惠乡村项目模板',
                                    html  : '<p style="font-size:15px;">目标<br/><br/>原理<br/><br/>创意阐述<br/><br/>技术实现<br/><br/>项目演示<br/><br/>团队介绍<br/><br/>团队故事<br/><br/><p>'
                                }
                            ],

                            onsubmit: function () {
                                editor.insertContent(
                                    '<h2><strong>目标</strong></h2>' +
                                    '<p class="p1"><span class="s1">总述项目想要解决的问题、实现的效果。</span></p>' +
                                    '<h2><strong>原理</strong></h2>' +
                                    '<ul class="ul1">' +
                                    '<li class="li1"><span class="s2">灵感来源（可选）</span></li>'+
                                    '<li class="li1"><span class="s2">思维导图</span></li>'+
                                    '<li class="li1"><span class="s2">目标人群（为谁设计的？）</span></li>'+
                                    '<li class="li1"><span class="s2">具体解决方案</span></li>'+
                                    '</ul>'+
                                    '<h2><strong>技术实现</strong></h2>' +
                                    '<p class="p1"><span class="s1">阐述项目的实现形式与实际研发需求。</span></p>'+
                                    '<h2><strong>项目演示</strong></h2>'+
                                    '<p class="p1"><span class="s1">通过“添加媒体”上传PPT</span></p>'+
                                    '<h2 class="p1"><strong>团队介绍</strong></h2>' +
                                    '<table style="height: 180px; border-color: #d8d8d8; background-color: #f9f9f9; width: 454px;" border="1" cellspacing="0" cellpadding="5px">'+
                                    '<tbody>'+
                                    '<tr style="height: 24px;">'+
                                    '<td style="width: 112px; height: 24px;">姓名</td>'+
                                    '<td style="width: 234px; height: 24px;">团队分工</td>'+
                                    '</tr>'+
                                    '<tr style="height: 96px;">'+
                                    '<td style="width: 112px; height: 96px;">张科科</td>'+
                                    '<td style="width: 234px; height: 96px;">'+
                                    '<p class="p1"><span class="s1">（均为示例，可修改）</span></p>'+
                                    '<p class="p1"><span class="s1">队长，组织协调进度</span></p>'+
                                    '</td>'+
                                    '<tr>'+
                                    '<tr style="height: 14.0625px;">'+
                                    '<td style="width: 112px; height: 14.0625px;">王蛋蛋</td>'+
                                    '<td style="width: 234px; height: 14.0625px;"><span class="s1">技术担当，资源协调</span></td>'+
                                    '</tr>'+
                                    '<tr style="height: 24px;">'+
                                    '<td style="width: 112px; height: 24px;">李华华</td>'+
                                    '<td style="width: 234px; height: 24px;">ppt制作</td>'+
                                    '</tr>'+
                                    '<tr style="height: 24px;">'+
                                    '<td style="width: 112px; height: 24px;">韩梅梅</td>'+
                                    '<td style="width: 234px; height: 24px;">海报制作，文档撰写</td>'+
                                    '</tr>'+
                                    '</tbody>'+
                                    '</table>'+
                                    '<h2><strong>团队故事</strong></h2>'+
                                    '团队联系方式：邮箱、QQ、电话等；'+
                                    '团队合作过程中发生的趣事、攻克的难关。'
                                );
                            }
                        });
                    }
                },
                {
                    text: '项目旅程记录模版',
                    onclick: function () {
                        editor.windowManager.open({
                            title: '项目旅程记录模版',
                            width: 400, //    对话框宽度
                            height: 350, //    对话框高度
                            body:[
                                {
                                    type   : 'container',
                                    name   : '项目旅程记录模版',
                                    html  : '<p style="font-size:15px;">项目目标<br/><br/>小组分工计划<br/><br/>本周进度<br/><br/>小组讨论情况<br/><br/>存在问题/解决方案<br/><br/>本周项目经验总结<br/><br/>项目旅程记录提交方式<br/><br/><p>'
                                }
                            ],

                            onsubmit: function () {
                                editor.insertContent(
                                    '<h2>项目旅程记录模版</h2>' +
                                    '<h2><strong>一、项目目标</strong></h2>' +
                                    '<span style="color: #ff0000;">项目灵感来源，项目的应用领域，解决的问题</span>' +
                                    '&nbsp;' +
                                    '<h2>二、小组分工计划</h2>'+
                                    '<p><span style="color: #ff0000;">每名组员计划负责内容，</span>比如：</p>'+
                                    '<p>张三：xxxxxx</p>'+
                                    '<p>李四：xxxxxx</p>'+
                                    '&nbsp;'+
                                    '<h2><strong>三、本周进度</strong></h2>' +
                                    '<p><span style="color: #ff0000;">完成内容占最终目标的百分比及是否达到预期；</span></p>'+
                                    '<p><span style="color: #ff0000;">实际个人贡献（<span style="font-size: 14pt;"><em><u>数字1-5</u></em></span>对应贡献程度，贡献越多数字越大）。</span></p>'+
                                    '<p>比如：'+
                                    '<p><span style="font-size: 14pt;"><strong>2018/11/1</strong></span></p>' +
                                    '<p>本周完成内容占最终完成目标30%，完成本周目标/未完成本周目标；</p>'+
                                    '<p>张三实际贡献：完成某个页面，<span style="color: #0000ff;"><strong>贡献度为3</strong></span></p>'+
                                    '<p>李四实际贡献：xxxxx</p>'+
                                    '&nbsp;'+
                                    '<p><span style="font-size: 14pt;"><strong>2018/11/8</strong></span></p>'+
                                    '<p>本周完成内容占最终完成目标50%，完成本周目标/未完成本周目标；</p>'+
                                    '<p>张三实际贡献：xxxxx</p>'+
                                    '<p>李四实际贡献：xxxxx</p>'+
                                    '<p>…</p>'+
                                    '<h2><strong>四、参考资料</strong></h2>'+
                                    '<p><span style="color: #ff0000;">完成项目时，参考了哪些学习资料（标题+链接+学习内容），<strong><em><span style="font-size: 14pt;"><u>每个人</u></span></em></strong>均需写出自己的</span>。比如：</p>'+
                                    '&nbsp;'+
                                    '<p><span style="font-size: 14pt;"><strong>2018/11/1</strong></span></p>'+
                                    '<p>张三：参考了火花空间上的xxx，链接，学习了点击按钮变色，并成功运用到自己的项目中…</p>'+
                                    '<p>李四：xxx</p>'+
                                    '&nbsp;'+
                                    '<p><span style="font-size: 14pt;"><strong>2018/11/8</strong></span></p>'+
                                    '<p>张三：xxx</p>'+
                                    '<p>…</p>'+
                                    '<h2>五、小组讨论情况</h2>'+
                                    '<p><span style="color: #ff0000;">讨论方式（线上/线下），讨论内容，参与人数，每次讨论时长</span>。比如：</p>'+
                                    '<p><span style="font-size: 14pt;"><strong>2018/11/1</strong></span></p>'+
                                    '<p>通过线上qq群，讨论了xxxxx，得出xxx结论，实际参与人数x人，讨论时长一小时；</p>'+
                                    '&nbsp;'+
                                    '<p><span style="font-size: 14pt;"><strong>2018/11/8</strong></span></p>'+
                                    '<p>通过线下在教室面对面交流，讨论了xxxxx，得出xxx结论，实际参与人数x人，讨论时长两小时；</p>'+
                                    '&nbsp;'+
                                    '<h2>六、存在问题/解决方案</h2>'+
                                    '<p><span style="color: #ff0000;"><strong><em><span style="font-size: 14pt;"><u>每名组员</u></span></em></strong>写出自己遇到的问题以及是如何解决的</span>，比如：</p>'+
                                    '<p><span style="font-size: 14pt;"><strong>2018/11/2</strong></span></p>'+
                                    '<p>张三：</p>'+
                                    '<p>问题一：</p>'+
                                    '<p>解决方案一：</p>'+
                                    '<p>问题二：</p>'+
                                    '<p>解决方案二：</p>'+
                                    '&nbsp;'+
                                    '<p>李四：</p>'+
                                    '<p>问题一：</p>'+
                                    '<p>解决方案一：</p>'+
                                    '<p><span style="font-size: 14pt;"><strong>2018/11/8</strong></span></p>'+
                                    '<p>张三：</p>'+
                                    '<p>问题三：</p>'+
                                    '<p>解决方案三：</p>'+
                                    '&nbsp;'+
                                    '<p>李四：</p>'+
                                    '<p>问题二：</p>'+
                                    '<p>解决方案二：</p>'+
                                    '<p>…</p>'+
                                    '<h2>七、对应代码</h2></p>'+
                                    '<p><span style="color: #ff0000;">需要<strong><em><span style="font-size: 14pt;"><u>每名组员</u></span></em></strong>将自己完成的代码张贴过来，若不是代码，也需将自己的完成内容展示出来</span>。比如：</p>'+
                                    '<p><span style="font-size: 14pt;"><strong>2018/11/8</strong></span></p>'+
                                    '<p>张三：xxxx</p>'+
                                    '<p>李四：xxxx</p>'+
                                    '&nbsp;'+
                                    '<p><span style="font-size: 14pt;"><strong>2018/11/16</strong></span></p>'+
                                    '<p>张三：xxxx</p>'+
                                    '<p>李四：xxxx</p>'+
                                    '<h2>八、本周项目经验总结</h2>'+
                                    '<p><span style="color: #ff0000;">本周反思（技术上的，团队合作上的…），下周计划等，除了小组整体的情况，<strong><em><span style="font-size: 14pt;"><u>每名组员</u></span></em></strong>均需填写自己的体会。</span>比如：</p>'+
                                    '<p>本周，我们组整体怎么怎么样，其中：</p>'+
                                    '<p>张三：…</p>'+
                                    '<p>李四：…</p>'+
                                    '&nbsp;'+
                                    '<hr/>'+
                                    '<h2>项目旅程记录提交方式</h2></p>'+
                                    '<p><strong>Step 1.</strong> 打开火花空间wiki页面，点击右侧“创建wiki”</p>'+
                                    '<img class="alignnone size-medium wp-image-60267" src="https://www.oursparkspace.cn/wp-content/uploads/2018/11/图片-1-800x379.png" alt="" width="800" height="379" />'+
                                    '<p><strong>Step 2.</strong> 将新创建的词条标题写为“组号 项目名称 项目旅程记录”（项目名称须与之前的项目词条标题一致）</p>'+
                                    '<p><strong>Step 3.</strong> 按照<span style="color: #ff0000;"><strong>给定模版（项目旅程记录模版）</strong></span>编写该词条，即项目旅程记录。</p>'+
                                    '<p><strong>Step 4.</strong> 点击“发布wiki”</p>'+
                                    '<p><strong>Step 5.</strong> “本周进度”“本周项目总结”周三之前更新一次即可，其余几点需要<span style="color: #ff0000; font-size: 14pt;"><strong>每名组员随时更新</strong></span>自己的内容，“项目目标”“小组计划分工”可以不变，<span style="color: #ff0000; font-size: 18pt;"><strong>注意：所有更新均需<u>注明日期（如</u></strong><strong><u>2018/11/1</u></strong><strong><u>）</u></strong></span>。比如（更多详细内容见“项目旅程记录模版”）：</p>'+
                                    '<p>X组 xxxxx项目 项目旅程记录</p>'+
                                    '<p>一、项目目标</p>'+
                                    '<p>二、小组计划分工</p>'+
                                    '<p>三、本周进度</p>'+
                                    '<p><span style="color: #0000ff;">四、参考资料</span></p>'+
                                    '<p><span style="color: #0000ff;"><strong>2018/11/1</strong></span></p>'+
                                    '<p><span style="color: #0000ff;">张三：xxx</span></p>'+
                                    '<p><span style="color: #0000ff;">李四：xxx</span></p>'+
                                    '<p><span style="color: #0000ff;">…</span></p>'+
                                    '&nbsp;'+
                                    '<p><span style="color: #0000ff;"><strong>2018/11/3</strong></span></p>'+
                                    '<p><span style="color: #0000ff;">张三：xxx</span></p>'+
                                    '<p><span style="color: #0000ff;">李四：xxx</span></p>'+
                                    '<p><span style="color: #0000ff;">…</span></p>'+
                                    '<p>五、讨论情况</p>'+
                                    '<p>六、存在问题/解决方案</p>'+
                                    '<p>七、对应代码</p>'+
                                    '<p>八、本周项目经验总结</p>'+
                                    '&nbsp;'+
                                    '<p>wiki的更新通过在Step 1-4 中创建的wiki上进行编辑（点击下图中右侧的“编辑wiki”按钮）</p>'+
                                    '<img class="alignnone size-medium wp-image-60268" src="https://www.oursparkspace.cn/wp-content/uploads/2018/11/图片-2-800x379.png" alt="" width="800" height="379" />'+
                                    '&nbsp;'+
                                    '<p><span style="font-size: 14pt; color: #ff0000;"><strong>Tips: 因为我们非常看重各小组协作学习的情况，所以请各小组<span style="font-size: 18pt;"><em><u>每位同学</u></em></span>一定要<span style="font-size: 18pt;"><em><u>随时且及时</u></em></span>在wiki上更新保存自己的增量，不能全由一位同学代写！各小组对本组项目旅程记录wiki的编辑情况（编辑次数，内容等）将是评分很重要的一部分！！！！！</strong></span></p>'
                                );
                            }
                        });
                    }
                },
                {
                    text: '腾讯云AI小程序项目模版',
                    onclick: function () {
                        editor.windowManager.open({
                            title: '腾讯云AI小程序项目模版',
                            width: 400, //    对话框宽度
                            height: 400, //    对话框高度
                            body:[
                                {
                                    type   : 'container',
                                    name   : '腾讯云AI小程序项目模版',
                                    html  : '<p style="font-size:15px;">简介<br/><br/>创意过程<br/><br/>用户分析<br/><br/>场景分析<br/><br/>系统功能拆解<br/><br/>功能实现<br/><br/>项目演示<br/><br/>团队介绍<br/><br/>团队故事<br/><p>'
                                }
                            ],

                            onsubmit: function () {
                                editor.insertContent(
                                    '<h2>简介</h2>'+
                                    '<span style="color: #ff0000;">一句话show出你们的小程序。总述小程序想要解决的问题、实现的效果。</span>' +
                                    '<h2>创意过程</h2>'+
                                    '<ul>'+
                                    '<li>疯狂八分钟：<span style="color: #ff0000;">（请罗列小组所有成员的创意点）</span></li>' +
                                    '<li>四象限法：<span style="color: #ff0000;">（请添加小组的四象限图，拍照或截图。为了保证图片能被正常查看，请务必通过上方工具栏左上角的“添加媒体”来插入图片。请保证图片清晰哦）</span></li>' +
                                    '</ul>' +
                                    '<h2>用户分析</h2>' +
                                    '<ul>' +
                                    '<li>目标用户：<span style="color: #ff0000;">（请文字描述）</span></li>' +
                                    '<li>用户画像：<span style="color: #ff0000;">（请添加用户画像图片。为了保证图片能被正常查看，请务必通过上方工具栏左上角的“添加媒体”来插入图片。请保证图片清晰哦）</span></li>' +
                                    '<li>痛点——需求点：根据用户特点的分析，归纳一下目标用户的痛点和相对应的需求。</li>' +
                                    '</ul>' +
                                    '<table style="border-color: #616161; width: 814px;" border="1px">' +
                                    '<tbody>' +
                                    '<tr>' +
                                    '<td style="width: 404.6875px;">' +
                                    '<p style="text-align: center;">痛点</p>' +
                                    '</td>' +
                                    '<td style="width: 400.3125px;">' +
                                    '<p style="text-align: center;">需求点</p>' +
                                    '</td>'+
                                    '</tr>'+
                                    '<tr>'+
                                    '<td style="width: 404.6875px;"></td>'+
                                    '<td style="width: 400.3125px;"></td>'+
                                    '</tr>'+
                                    '<tr>'+
                                    '<td style="width: 404.6875px;"></td>'+
                                    '<td style="width: 400.3125px;"></td>'+
                                    '</tr>'+
                                    '<tr>'+
                                    '<td style="width: 404.6875px;"></td>'+
                                    '<td style="width: 400.3125px;"></td>'+
                                    '</tr>'+
                                    '<tr>'+
                                    '<td style="width: 404.6875px;"></td>'+
                                    '<td style="width: 400.3125px;"></td>'+
                                    '</tr>'+
                                    '</tbody>'+
                                    '</table>'+
                                    '&nbsp;'+
                                    '<h2>场景分析</h2>'+
                                    '目标用户的使用路径可能是这样的：'+
                                    '<span style="color: #ff0000;">（请添加用户旅程图图片。为了保证图片能被正常查看，请务必通过上方工具栏左上角的“添加媒体”来插入图片。请保证图片清晰哦）</span>'+
                                    '&nbsp;'+
                                    '<h2>系统功能拆解</h2>'+
                                    '请根据组件认知与系统功能拆解，完成小组创意小程序的核心功能实现的技术分析：'+
                                    '<table style="border-color: #5e5e5e; width: 803px;" border="1px">'+
                                    '<tbody>'+
                                    '<tr>'+
                                    '<td style="width: 395.140625px;">'+
                                    '<p style="text-align: center;">小程序核心功能</p>'+
                                    '</td>'+
                                    '<td style="width: 396.859375px;">'+
                                    '<p style="text-align: center;">技术模块</p>'+
                                    '</td>'+
                                    '</tr>'+
                                    '<tr>'+
                                    '<td style="width: 395.140625px; text-align: center;"><span style="color: #ff0000;"> 功能1</span></td>'+
                                    '<td style="width: 396.859375px; text-align: center;"><span style="color: #ff0000;"> 功能1对应的组件</span></td>'+
                                    '</tr>'+
                                    '<tr>'+
                                    '<td style="width: 395.140625px; text-align: center;"><span style="color: #ff0000;"> 功能2</span></td>'+
                                    '<td style="width: 396.859375px; text-align: center;"><span style="color: #ff0000;"> 功能2对应的组件</span></td>'+
                                    '</tr>'+
                                    '<tr>'+
                                    '<td style="width: 395.140625px;"></td>'+
                                    '<td style="width: 396.859375px;"></td>'+
                                    '</tr>'+
                                    '<tr>'+
                                    '<td style="width: 395.140625px;"></td>'+
                                    '<td style="width: 396.859375px;"></td>'+
                                    '</tr>'+
                                    '</tbody>'+
                                    '</table>'+
                                    '<strong> </strong>'+
                                    '<h2>功能实现</h2>'+
                                    '<span style="color: #ff0000;">解读每个功能模块的实现过程，并讲解一下重要部分的代码。</span>'+
                                    '&nbsp;'+
                                    '<h2>项目演示</h2>'+
                                    '<span style="color: #ff0000;">通过“添加媒体”上传PPT</span>'+
                                    '&nbsp;'+
                                    '<h2><strong>团队介绍</strong></h2>'+
                                    '<table style="height: 180px; border-color: #616161; width: 454px;" border="1px" width="454">'+
                                    '<tbody>'+
                                    '<tr>'+
                                    '<td style="width: 142.15625px; text-align: center;">姓名</td>'+
                                    '<td style="width: 295.859375px; text-align: center;">团队分工</td>'+
                                    '</tr>'+
                                    '<tr>'+
                                    '<td style="width: 142.15625px; text-align: center;">张科科</td>'+
                                    '<td style="width: 295.859375px; text-align: center;"><span style="color: #ff0000;">（均为示例，可修改）</span>'+
                                    '<span style="color: #ff0000;">队长，组织协调进度</span></td>'+
                                    '</tr>'+
                                    '<tr>'+
                                    '<td style="width: 142.15625px; text-align: center;">王蛋蛋</td>'+
                                    '<td style="width: 295.859375px; text-align: center;"><span style="color: #ff0000;">技术担当，资源协调</span></td>'+
                                    '</tr>'+
                                    '<tr>'+
                                    '<td style="width: 142.15625px; text-align: center;">李华华</td>'+
                                    '<td style="width: 295.859375px; text-align: center;"><span style="color: #ff0000;">ppt制作</span></td>'+
                                    '</tr>'+
                                    '<tr>'+
                                    '<td style="width: 142.15625px; text-align: center;">韩梅梅</td>'+
                                    '<td style="width: 295.859375px; text-align: center;">'+
                                    '<p style="text-align: center;"><span style="color: #ff0000;">海报制作，文档撰写</span></p>'+
                                    '</td>'+
                                    '</tr>'+
                                    '</tbody>'+
                                    '</table>'+
                                    '&nbsp;'+
                                    '<h2>团队故事</h2>'+
                                    '<span style="color: #ff0000;">团队合作过程中发生的趣事、攻克的难关等。</span>'+
                                    '&nbsp;'+
                                    '<h2><strong>参考资料</strong></h2>'+
                                    '<span style="color: #ff0000;">完成项目时，参考了哪些学习资料？请附上链接，相信你提供的资源能为其他初学者带来很大的帮助！</span>'+
                                    '&nbsp;'+
                                    '&nbsp;'
                                );
                            }
                        });
                    }
                }
            ]
        })
    });
})();
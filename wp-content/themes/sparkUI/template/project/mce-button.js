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
                }
            ]
        });
    });
})();
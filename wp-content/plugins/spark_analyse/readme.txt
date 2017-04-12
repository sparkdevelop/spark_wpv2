fenci文件夹是用来执行分词程序的，将会在model_drawing.php里被调用。
model_drawing.php是用来实现分词的，预计在算法革新后会被调用，暂时搁置。
spark analyse是主程序，实现创建菜单的作用。
菜单分为两部分，一部分名为数据分析，是用来记录所要查询用户的用户名，
另一部分名为：查看用户画像，是用来将用户画像可视化。
analyseview.php：用户画像可视化的具体代码
timechart:调用数据库程序，为analyseview提供数据参数。
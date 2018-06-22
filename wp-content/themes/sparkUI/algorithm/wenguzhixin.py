#!/usr/bin/python
# -*- coding: UTF-8 -*-
import MySQLdb
import numpy as np
import random
db = MySQLdb.connect("localhost","root","zx1101","spark_wp",charset="utf8" )


# db = MySQLdb.connect("localhost","root","zx1101","spark_wp",charset="utf8")
cursor = db.cursor()
count=0
sql="drop table if exists wp_user_review"
cursor.execute(sql)
sql="create table wp_user_review(ID integer PRIMARY KEY,review_old varchar(50),know_new varchar(50))default charset=utf8;"
cursor.execute(sql)


chineseClasses=["通信","计算机","电子","人工智能","其他"]
englishClasses=["comunication","computer","electronics","AI","other"]
sql="select distinct wiki_id from new_wiki"
cursor.execute(sql)
results=cursor.fetchall()
wiki=[]
for row in results:
	wiki.append(row[0])
classToWikiListDict={}
for i in englishClasses:
	classToWikiListDict[i]=[]
	chineseVersion=chineseClasses[englishClasses.index(i)]
	sql="select distinct wiki_id from new_wiki where class='%s'"%(chineseVersion)
	cursor.execute(sql)
	results=cursor.fetchall()
	for row in results:
		classToWikiListDict[i].append(row[0])
userIDToWikiDict={}
sql="select ID from wp_users"
cursor.execute(sql)
usersID= cursor.fetchall()

for userID in usersID:
	ID=userID[0]
	# print ID,":"
	sql="select action_post_id from wp_user_history where action_post_type='%s' AND user_id='%d'"%("yada_wiki",ID)
	userIDToWikiDict[ID]={"wikiIDList":[],"wikiBrowseNumber":[],"wikiClassList":[]}
	cursor.execute(sql)
	results=cursor.fetchall()
	for i in results:
		sql="select class from new_wiki where wiki_id='%d'"%(i[0])
		cursor.execute(sql)
		result=cursor.fetchone()
		if result:
			wikiClass=result[0]
			# print wikiClass
		else:
			wikiClass=None
		if wikiClass!=None and wikiClass.encode("utf8") in chineseClasses:
			if i[0] not in userIDToWikiDict[ID]["wikiIDList"]:
				userIDToWikiDict[ID]["wikiIDList"].append(i[0])
				userIDToWikiDict[ID]["wikiBrowseNumber"].append(1)
			else:
				userIDToWikiDict[ID]["wikiBrowseNumber"][userIDToWikiDict[ID]["wikiIDList"].index(i[0])]+=1
	# print "wikiIDList",userIDToWikiDict[ID]["wikiIDList"]
	# print "wikiBrowseNumber",userIDToWikiDict[ID]["wikiBrowseNumber"]
	userIDToWikiDict[ID]["wikiBrowseNumber"]=np.asarray(userIDToWikiDict[ID]["wikiBrowseNumber"])
	ind=np.argpartition(userIDToWikiDict[ID]["wikiBrowseNumber"], -len(userIDToWikiDict[ID]["wikiBrowseNumber"]))[-len(userIDToWikiDict[ID]["wikiBrowseNumber"]):]
	ind=ind[np.argsort(userIDToWikiDict[ID]["wikiBrowseNumber"][ind])]
	userIDToWikiDict[ID]["wikiBrowseNumber"]=userIDToWikiDict[ID]["wikiBrowseNumber"][ind]
	userIDToWikiDict[ID]["wikiIDList"]=np.asarray(userIDToWikiDict[ID]["wikiIDList"])[ind]
	# print "wikiIDList",userIDToWikiDict[ID]["wikiIDList"].tolist()
	# print "wikiBrowseNumber",userIDToWikiDict[ID]["wikiBrowseNumber"].tolist()
	for wikiID in userIDToWikiDict[ID]["wikiIDList"]:
		sql="select class from new_wiki where wiki_id='%d'"%(wikiID)
		cursor.execute(sql)
		wikiClass=cursor.fetchone()[0]
		index=chineseClasses.index(wikiClass.encode("utf8"))
		userIDToWikiDict[ID]["wikiClassList"].append(englishClasses[index])
	# print "wikiClassList",userIDToWikiDict[ID]["wikiClassList"]
	if userIDToWikiDict[ID]["wikiClassList"]:
		classList=[0,0,0,0,0]
		for i in userIDToWikiDict[ID]["wikiClassList"]:
			classList[englishClasses.index(i)]+=1
		maxBrowseClass=englishClasses[classList.index(max(classList))]
	else:
		maxBrowseClass=None
	# print "maxBrowseClass",maxBrowseClass
	if len(userIDToWikiDict[ID]["wikiIDList"])<=5:
		review_old=userIDToWikiDict[ID]["wikiIDList"]
	else:
		if len(userIDToWikiDict[ID]["wikiIDList"])<=10:
			newWikiIDList=list(userIDToWikiDict[ID]["wikiIDList"])
			random.shuffle(newWikiIDList)
			review_old=newWikiIDList[:5]
		else:
			newWikiIDList=list(userIDToWikiDict[ID]["wikiIDList"][:5])+list(userIDToWikiDict[ID]["wikiIDList"][-5:])
			random.shuffle(newWikiIDList)
			review_old=newWikiIDList[:5]
	if maxBrowseClass==None:
		newWikiIDList=list(wiki)
		random.shuffle(newWikiIDList)
		know_new=newWikiIDList[:5]
	else:
		maxClassKnowNew=list(set(classToWikiListDict[maxBrowseClass])-set(userIDToWikiDict[ID]["wikiIDList"]))
		random.shuffle(maxClassKnowNew)
		otherClassWiki=list(set(wiki)-set(userIDToWikiDict[ID]["wikiIDList"])-set(classToWikiListDict[maxBrowseClass]))
		random.shuffle(otherClassWiki)
		know_new=maxClassKnowNew[:3]+otherClassWiki[:2]
	# print "review_old",review_old
	# print ','.join(map(str,review_old))
	userIDToWikiDict[ID]["review_old"]=','.join(map(str,review_old))
	# print "know_new",know_new
	# print ','.join(map(str,know_new))
	userIDToWikiDict[ID]["know_new"]=','.join(map(str,know_new))


# insert into table 
sql="insert into wp_user_review(ID,review_old,know_new)values"
keys=userIDToWikiDict.keys()
for userID in keys[:-1]:
	ID=userID
	single="('%d','%s','%s'),"%(ID,userIDToWikiDict[ID]["review_old"],userIDToWikiDict[ID]["know_new"])
	sql=sql+single
lastUserID=keys[-1]
single="('%d','%s','%s');"%(lastUserID,userIDToWikiDict[lastUserID]["review_old"],userIDToWikiDict[lastUserID]["know_new"])
sql=sql+single
try:
   # 执行sql语句
   cursor.execute(sql)
   # 提交到数据库执行
   db.commit()
except:
   # Rollback in case there is any error
   db.rollback()
db.close()


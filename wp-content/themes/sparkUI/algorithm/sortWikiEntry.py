# -*- coding: utf-8 -*-
import MySQLdb
import re
import jieba
import math
import numpy as np
import json
from pyquery import PyQuery
#from scipy import spatial
db=MySQLdb.connect(host="localhost",user="root",passwd="zx1101",db="spark_wp",charset='utf8')
cursor = db.cursor()
cursor.execute("select ID,post_title from wp_posts where post_type='yada_wiki';")
data=cursor.fetchall()
wikiEntryDict={s[0]:s[1] for s in data}
cursor.execute("select ID,post_title from wp_posts where post_type='post';")
data=cursor.fetchall()
postDict={s[0]:s[1] for s in data}
postIDToWikiEntryIDDict={}
postIDToSortedWikiEntryIDDict={}
wikiEntryIDToPostIDDict={}
postIDToPostContentDict={}
postIDToSegListDict={}
count=0
delete=0
maxEntry=0
no=0
for postID in postDict.keys():
	postTitle=postDict[postID]
	cursor.execute("select post_content from wp_posts where ID="+str(postID)+";")
	data=cursor.fetchone()
	postContent=data[0]
	mode='<div class="mw-highlight mw-content-ltr" dir="ltr">([\S\s]*?)</div>'
	postContent=re.sub(mode,"",postContent)
	if postContent=="":
		del postDict[postID]
		delete+=1
	else:
		postContent = PyQuery(postContent)
		postContent=postContent.text()
		postIDToPostContentDict[postID]=postContent
		for wikiEntryID,wikiEntryTitle in wikiEntryDict.iteritems():
			if postContent.count(wikiEntryTitle)!=0:
				count+=1
				if postID in postIDToWikiEntryIDDict:
					postIDToWikiEntryIDDict[postID].append(wikiEntryID)
				else:
					postIDToWikiEntryIDDict[postID]=[wikiEntryID]
				if wikiEntryID in wikiEntryIDToPostIDDict:
					wikiEntryIDToPostIDDict[wikiEntryID].append(postID)
				else:
					wikiEntryIDToPostIDDict[wikiEntryID]=[postID]
	if postID in postIDToPostContentDict:
		if postID in postIDToWikiEntryIDDict and len(postIDToWikiEntryIDDict[postID])>maxEntry:
			maxEntry=len(postIDToWikiEntryIDDict[postID])
		seg_list_generator= jieba.cut(postContent, cut_all=False)
		seg_list=list(seg_list_generator)
		postIDToSegListDict[postID]=seg_list
	else:
		no+=1

# sort wikiEntry
for postID in postDict.keys():
	postTitle=postDict[postID]
	if postID in postIDToWikiEntryIDDict:
		postContent=postIDToPostContentDict[postID]
		wikiEntryIDListToBeSorted=[]
		tf_idfList=[]
		for wikiEntryID in postIDToWikiEntryIDDict[postID]:
			wikiEntryTitle=wikiEntryDict[wikiEntryID]
			tf=postContent.count(wikiEntryTitle)/float(len(seg_list))
			occurenceInAllPosts=0
			for wikiEntryIDList in postIDToWikiEntryIDDict.itervalues():
				if wikiEntryID in wikiEntryIDList:
					occurenceInAllPosts+=1
			idf=math.log(len(postIDToWikiEntryIDDict)/float(1+occurenceInAllPosts),2)
			tf_idf=tf*idf
			tf_idfList.append(tf_idf)
			wikiEntryIDListToBeSorted.append(wikiEntryID)
		sortedWikiEntryIndex=sorted(range(len(tf_idfList)), key=lambda k: tf_idfList[k])
		wikiEntryIDListToBeSorted=np.array(wikiEntryIDListToBeSorted)
		sortedWikiEntryIDList=wikiEntryIDListToBeSorted[sortedWikiEntryIndex]
		sortedWikiEntryIDList=sortedWikiEntryIDList.tolist()
		sortedWikiEntryIDList.reverse()
		tf_idfList=np.array(tf_idfList)
		sortedTf_idfList=tf_idfList[sortedWikiEntryIndex]
		sortedTf_idfList=sortedTf_idfList.tolist()
		sortedTf_idfList.reverse()
		postIDToSortedWikiEntryIDDict[postID]=sortedWikiEntryIDList
json.dump(postIDToSortedWikiEntryIDDict,open("postIDToSortedWikiEntryIDDict.json","w"))
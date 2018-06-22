#!/usr/bin/env python
# -*- coding: utf-8 -*- 
import numpy as np
size=[45,15,5,3]
parentToChildDict={}
childToParentDict={}
nodeToIDDict={}
IDToNodeDict={}
categories=[{"name":"电子"},{"name":"通信"},{"name":"计算机"},{"name":"人工智能"}]
rootToTree={}
nodeToLayer={}
nodes=["电子","通信","计算机","人工智能"]
for i in nodes:
	rootToTree[i]=[i]
nodeToTree={}
with open("wp-content/themes/sparkUI/algorithm/categoryNet.txt","r") as rf:
	for line in rf:
		line=line.strip('\n')
		parentNode,childNode=line.split("，")
		if parentNode not in nodes:
			nodes.append(parentNode)
		if childNode not in nodes:
			nodes.append(childNode)
		if parentNode not in parentToChildDict:
			parentToChildDict[parentNode]=[childNode]
		else:
			parentToChildDict[parentNode].append(childNode)
		childToParentDict[childNode]=parentNode
#print len(nodes)

for i in rootToTree.keys():
	for j in parentToChildDict[i]:
		if j not in rootToTree[i]:
			rootToTree[i].append(j)
		if j in parentToChildDict:
			for k in parentToChildDict[j]:
				if k not in rootToTree[i]:
					rootToTree[i].append(k)
				if k in parentToChildDict:
					for l in parentToChildDict[k]:
						if l not in rootToTree[i]:
							rootToTree[i].append(l)

nodeToLayer={"电子":0,"通信":0,"计算机":0,"人工智能":0}
for i in nodeToLayer.keys():
	for j in parentToChildDict[i]:
		if j not in nodeToLayer:
			nodeToLayer[j]=1
			if j in parentToChildDict:
				for k in parentToChildDict[j]:
					nodeToLayer[k]=2
					if k in parentToChildDict:
						for l in parentToChildDict[k]:
							nodeToLayer[l]=3


for i in rootToTree.keys():
	for j in rootToTree[i]:
		nodeToTree[j]=i
nodelist=[]
for i in nodes:
	nodelist.append({"name":i,"value":size[nodeToLayer[i]],"category":nodes.index(nodeToTree[i])})
links=[]
with open("wp-content/themes/sparkUI/algorithm/categoryNet.txt","r") as rf:
	for line in rf:
		line=line.strip("\n")
		parentNode,childNode=line.split("，")
		links.append({"source":nodes.index(parentNode),"target":nodes.index(childNode)})

#print "nodelist",len(nodelist)
#print "len(links)",len(links)

import json
data={"categories":categories,"nodes":nodelist,"links":links}
jsonString = json.dumps(data)
print jsonString
#json.dump(data,open("data.json","w"))
count=0
for i in rootToTree:
	count+=len(rootToTree[i])
print count

#for i in nodes:
#	print i,
#print ""
#print ""
#n=[]
#for i in rootToTree:
#	for j in rootToTree[i]:
#		n.append(j)
#		print j,
#print len(set(n))
# for i in parentToChildDict:
# 	print i,":",
# 	for j in parentToChildDict[i]:
# 		print j,
# 	print ""

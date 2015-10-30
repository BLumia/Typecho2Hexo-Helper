#!/bin/bash

#exists_pattern_files() {
#    ls|grep "\.md"
#}
clear
#if exists_pattern_files ; then
	ls | grep "\.md"
	#read -n1
	rm -rf *.md
#fi
if [ -f "infolist.html" ]; then
	echo "removing [infolist.html]..."
	rm -rf infolist.html
fi
wget http://3.blogblumia.sinaapp.com/typecho2hexo.php -O infolist.html
#wget -i infolist.html -F --restrict-file-names=nocontrol --content-disposition

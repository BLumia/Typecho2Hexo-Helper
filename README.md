# Typecho2Hexo Helper

## Introduction

This is just a simple php script for user who want to move his/her typecho archives to hexo. this script will help you get your archive list and you can download them all by yourself or by using other softwares' help like wget.

After that, you can get all your archives as TITLE.md format. place the files to your hexo archive folder and... it's done.

## Usage

1. get the php scripts and edit the *Run Enviroment and DB setting* part at *typecho2hexo.php*.
2. upload them to the server where you deploy the typecho.
3. visit http://YourTypechoSite.domain/path/to/typecho2hexo.php for your archive list.
4. Download the archive via the link at the web page which step 2 was given.

## If you are using wget

Maybe this is helpful to you:

		wget http://YourTypechoSite.domain/path/to/typecho2hexo.php -O infolist.html
		wget -i infolist.html -F --restrict-file-names=nocontrol --content-disposition

P.s. If you have archives which have the same title, the file you download may like name.md, name.md.1 name.md.2 ... Just rename them as you like.

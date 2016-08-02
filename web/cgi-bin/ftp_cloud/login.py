#! /usr/bin/python
#-*-coding:utf-8-*-
from ftplib import FTP
from ftplib import error_perm
import cgi, sys, os, urllib
#from FileType import getFileParser
from urllib import unquote

Prot = "ftp:/"
print 'Content-type:text/html\n\n'

template = """
	<html><head><title> {0} 的索引</title>	<meta charset="gb2312"><link herf="css/bootstrap.min.css" type="text/css" rel="stylesheet"></head><body>{1}</body></html>
"""

class ftpTest(object):

	def __init__(self, url='10.63.240.251', cur='', username='ytsw03',\
		password='123456'):
		self.url = url
		self.current = cur
		self.userinfo = {
			"username" : username,
			"password" : password,
			}
		self.pieces = ""
		self.flag = False
		self.login()
		self.refresh()
		self.output()
		
	def login(self):
		self.ftp = FTP(self.url)
		self.ftp.login(self.userinfo['username'], self.userinfo['password'])
		self.ftp.set_pasv(True)
	def refresh(self):		
		try:
			wd = os.path.join(self.ftp.pwd(), self.current)
			self.ftp.cwd(wd)
			parseMethod = self.parseDir
		except error_perm:
			self.ftp.sendcmd('TYPE I')
			parseMethod = self.parse(self.current)
		finally:
			parseMethod()
			self.ftp.quit()

	def parse(self, f):
		return getattr(self, "parse%s" % getFileParser(f))

	def parseDir(self):
		self.get_list()
		self.pieces = '<form method="get" action="cgitest.cgi"><h1 id="header"class="text-info"> %s&nbsp;&nbsp;的索引\
			</h1><hr/>' % (os.sep + self.current)
		self.pieces += '<table id="table"><tbody><tr><td>选择</td><td>名称\
			</td><td>大小</td><td>修改日期</td></tr></tbody>'
		for x in self.ll:
			self.pieces += '<tr>'
			name = x.get('name')
			##print name
			wd = os.path.join(self.ftp.pwd())+"/"
			if x.get("type") == 'file':
				self.pieces += '<td><input type="checkbox" value="'+name+'" name="'+wd+'"/></td>'				
			else :
				self.pieces += '<td></td>'
	#		name = x.get('name')
			value = {'cur' : os.path.join(self.current, name)}
			value.update(self.userinfo) 
			data = urllib.urlencode(value)
			self.pieces += '<td><a href="login.py?{0}" >{1}</a></td><td>{2}\
				</td><td>{3}</td></tr>' .format(data, name, x.get("size"),\
				x.get('ctime'))
			
		self.pieces += '</table><input type="submit" value="Upload" style="margin-top:10px; background:#32cd32; color:#fff; border:none; width:80px; text-align:center; height:30px;"></form>'
		print self.pieces
	def parsePict(self):
		self.pieces = '<img style="-webkit-user-select: none; cursor: \
			zoom-in;"src="%s">' % os.path.join(Prot ,self.url , self.current)

	def parseAudio(self):
		self.pieces = '<audio controls autoplay name="media">\
			<source src="%s" type="audio/webm"> </audio>' % os.path.join(Prot,\
			self.url, self.current)

	def parseVideo(self):
		self.pieces = '<video controls autoplay name="media">\
			<source src="%s" type="video/webm"> </video>' % os.path.join(Prot,\
			self.url, self.current)

	def parseText(self):
		self.ftp.retrbinary('RETR ' + self.current, self.printData)

	def parseOthers(self):
		self.flag = True
		self.pieces = 'Content-Disposition:attachment; filename=%s\n\n \
			Content-Length:%s\n\nContent-Type:application/octet-stream\n\n'\
			% (self.current, self.ftp.size(self.current))
		self.ftp.retrbinary('RETR ' + f, stdout.write)
	
	def get_list(self):
		self.ll = []
		self.ftp.dir(self.get_fileinfo)

	def get_fileinfo(self, x):
		fileinfo = dict(zip(('type', 'size', 'ctime', 'name'), (x[0] == 'd'\
			and 'dir' or 'file', x[30:43].strip(), x[43:56].strip(), x[56:]\
			.strip())))
		self.ll.append(fileinfo)

	def printData(self, data):
		self.pieces = '<pre style="word-wrap: break-word; white-space;\
			pre-wrap;">%s</pre>' % data

	def output(self):
	##	print "Content-type:text/html\n\n"
		if self.flag : print self.pieces
		else : print ty,template.format(self.current if self.current else '/',self.pieces)
					
if __name__ == "__main__":
		
	form = cgi.FieldStorage()
	args = dict(zip(form.keys(), [form.getvalue(key) for key in form.keys()]))
	ff = ftpTest(**args)
	##ff=ftpTest()

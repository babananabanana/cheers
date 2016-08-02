#include <stdio.h>
#include <stdlib.h>
#include <string.h>
void urldecode(char *p);
int main(int argc,char*argv[]) {
	char *data = NULL;
	int len,nel;
	char *q,*value,*name;
	char cmd[80];
        char username[80][80] ;
	printf("%s%c%c\n","Content-Type:text/html;charset=utf-8",13,10);
	printf("<TITLE>Uploading</TITLE>\n");
	data = getenv("QUERY_STRING");
	printf("%s",data);
	urldecode(data);

	printf("%s",data);
	q = data;
	nel = 0;
	len = strlen(data);
	int i = 0;
	if (data == NULL)
		printf("<p>Error!Error in passing data from form to script.");
	else {
	while(strsep(&q,"&"))
			nel++;
		for(q=data;q<(data+len);){
			value=name=q;
			for(q+=strlen(q);q<(data+len)&&!*q;q++);
			name=strsep(&value,"=");
			printf("%s\n",name);
			printf("%s\n",value);
			printf("<br/>");
			sprintf(cmd,"sh cloud.sh %s",value);
			printf("%s",cmd);
	//		system("ls");
				system(cmd);
		}
	}
	return 0; 
}
void urldecode(char *p)  
{  
	register i=0;  
	while(*(p+i))  
	{  
		   if ((*p=*(p+i)) == '%')  
		   	      {  
		   	      	      *p=*(p+i+1) >= 'A' ? ((*(p+i+1) & 0XDF) - 'A') + 10 : (*(p+i+1) - '0');  
		   	      	          *p=(*p) * 16;  
		   	      	              *p+=*(p+i+2) >= 'A' ? ((*(p+i+2) & 0XDF) - 'A') + 10 : (*(p+i+2) - '0');  
		   	      	                  i+=2;  
		   	      	                     }  
		      else if (*(p+i)=='+')  
		      	     {  
		      	     	     *p=' ';  
		      	     	        }  
		         p++;  
	}  
	*p='\0';  
}  

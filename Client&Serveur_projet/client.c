#include <unistd.h>
#include <sys/types.h>
#include <sys/socket.h>
#include <stdio.h>
#include <errno.h>
#include <stdlib.h>
#include <strings.h>
#include <netinet/in.h>
#include <netdb.h>
#include <signal.h>
#include <string.h>
#include <fcntl.h>
#include <ncurses.h>
#include "strhelpers.h"
#include <stdint.h>
#include <getopt.h>
#include "fun_targa.h"
#include "mem_targa.h"
#define MAXTEXT 1024





// Definition des prototypes de fonctions appelees dans le fichier
void write_header(int sock, char * username);
void print_msg(char * chat);
void recv_img(int sock, long img_size,char * input);
int main(int argc, char * argv[])
{
  int sock;
  int sock_talk;
  int port;
  int port_talk = 1111;
  int pidFils;
  char *username;
  struct hostent * hote;
  struct sockaddr_in adr;

  // On verifie qu'il y a au moins 2 options donnees au lancement du client
  if (argc!=4)
  {
    fprintf(stderr,"Usage : %s machine port-number username\n", argv[0]);
    exit(1);
  }
  // Creation d'un socket pour initier le rendez-vous du client avec le serveur
  sock=socket(AF_INET, SOCK_STREAM, 0);
  if (sock == -1)
  {
    fprintf(stderr, "Socket rendez-vous n'a pu etre cree");
    exit(1);
  }
  // On recupere la structure de donnee hote a partir du nom de la machine
  hote=gethostbyname(argv[1]);
  port=atoi(argv[2]);
  username=argv[3];
  printf("User: %s - %d; Machine: %s\n", username, geteuid(), argv[1]);

  /* Connexion au service */
  // On convertit l'addresse de l'hote en type compatible avec le type de socket
  // choisi (AF_INET/SOCK_STREAM)
  adr.sin_family=AF_INET;
  adr.sin_port=htons(port);
  bcopy(hote->h_addr, &adr.sin_addr.s_addr, hote->h_length);
  // On demande a se connecter
  int connectResult = connect(sock, (struct sockaddr *)&adr, sizeof(adr));
  if (connectResult ==-1)
  {
    fprintf(stderr, "Erreur de connexion");
    exit(1);
  }


  /* Connexion au talk */
  sock_talk=socket(AF_INET, SOCK_STREAM, 0);
  if (sock == -1)
  {
    fprintf(stderr, "Socket rendez-vous pour talk n'a pu etre cree\n");
    exit(1);
  }
  // On convertit l'addresse de l'hote en type compatible avec le type de socket
  // choisi (AF_INET/SOCK_STREAM)
  adr.sin_family=AF_INET;
  adr.sin_port=htons(port_talk);
  bcopy(hote->h_addr, &adr.sin_addr.s_addr, hote->h_length);
  // On demande a se connecter
  sleep(1);
  connectResult = connect(sock_talk, (struct sockaddr *)&adr, sizeof(adr));
  if (connectResult ==-1)
  {
	perror("Erreur de connexion au talk");
    exit(1);
  }
  printf("Connexion  établie \n\n\n");


  char c;
  char *chat =  malloc(MAXTEXT);
  char *begchat = chat;
  long img_size ;
  int i=0;
  char *msgclient = malloc(MAXTEXT);
  char * list=malloc(sizeof(char)*100);
  char * list2[100];
  const char s[2] = " ";
  char *token;
  /* Le premier message ecrit le nom de l'utilisateur */
          write_header(sock_talk, username);

	  // recevoir la liste des images images 
	  read(sock,chat,25);
	  printf("|------%s------| \n\n",chat);
          read(sock,list, sizeof(char)*100); 
          token = strtok(list, s);
          while( token != NULL ) 
   		{
                list2[i]=token;
 
      		printf( "|      ------%d- %s\n",i+1, list2[i]);
             
      		token = strtok(NULL, s);
		i++;
  		}
	  printf("\n");	
          printf("|------                        ------| \n\n");

	  // choix de l'image (5)
	  int  choix;
          do
	  {
	     scanf("%d",&choix);
	  }while(choix<=0 || choix>5);
	  
	  write(sock, list2[choix-1], sizeof(char)*25);
          printf("choissez le type du chiffrement \n\n");
          printf("a.CESAR\n");
	  printf("b.VIGENERE\n");
	  printf("c.AES\n\n\n");

	  printf("Analyse Histograme des images\n\n");
          printf("d.Histogramme d'un canal\n");
	  printf("e.Histogramme des 3 canaux\n");
	  printf("f. Histogramme chifré\n");
	  
	  char mode;
	  do
	  {
	   mode = getchar();
	  }while(mode!='a' && mode!='b' && mode!='c' &&  mode!='d' &&  mode!='e' &&  mode!='f' );



	  // envoie du choix du cryptage
	  write(sock, &mode, sizeof(char));

           if(mode=='a' || mode=='b' || mode=='c'   )
  
          {
          
          // lecture et reception de l'image 
          image_desc i_img, o_img;
	  targa_header i_head; /* Header of input image */
	  char *inputfn=malloc(sizeof(char)*30),*outputfn=malloc(sizeof(char)*30);
          read(sock, &img_size, sizeof(long));
	  printf("Taille de l'image a recevoir : %ld\n", img_size);
          strcpy(inputfn,"");
    	  strcat(inputfn,"image_client/");
	  strcat(inputfn,"encode_");
	  strcat(inputfn,list2[choix-1]);
	
	  strcpy(outputfn,"");
    	  strcat(outputfn,"image_client/");
    	  strcat(outputfn,"decode_");
	  strcat(outputfn,list2[choix-1]);
	  recv_img(sock, img_size,inputfn);
          // décryptage //
	  // READ
	  readImage(&i_img, &i_head, inputfn);
	  
	  int n=5,tab[n];
	  int key=10;
	  tab[0]=18;tab[1]=44;tab[2]=159;tab[3]=147;tab[4]=16;
     
 printf("%c",mode);     
 if(mode=='a') {

     		int cesar= cesar_decode(i_img,&o_img,key); 
              }


  else if(mode=='b')
	      {
		int vigenere= vigenere_decode(i_img,&o_img,tab,n); 
	      }

  else if(mode=='c')
	      {
		int aes = aes_decode(i_img,&o_img);
	      }
	  // WRITE
	  writeImage(o_img, i_head,outputfn);
	  freeImage(&o_img);

	}
	else if( mode=='d'  )

	{
		  int * c;
                  printf("Donner le canal pour recevoir son histogramme\n");
		  printf("1 - Rouge\n");
		  printf("2 - Vert\n");
		  printf("3 - Bleu\n");
		  do{                  
		  scanf("%d",c);
		  }while((*c)!=1 && (*c)!=2 && (*c)!=3 );
	          write(sock,c, sizeof(int));
                  int crypt;
		  printf("Cryptage Histo 0/1\n");
		  scanf("%d",&crypt);
		  write(sock,&crypt, sizeof(int));
		  
		  

           
	  image_desc i_img, o_img;
	  targa_header i_head; /* Header of input image */
	  char *inputfn=malloc(sizeof(char)*30),*outputfn=malloc(sizeof(char)*30);
          read(sock, &img_size, sizeof(long));
	  printf("Taille de l'image a recevoir : %ld\n", img_size);
          strcpy(inputfn,"");
    	  strcat(inputfn,"image_client/");
	  strcat(inputfn,"histo_");
	  recv_img(sock, img_size,inputfn);
          

          	
	}






  close(sock);
  close(sock_talk);	   
  return 0;
}


void recv_img(int sock, long img_size, char *inputfn) {
  char *buffer = malloc(img_size);
  int readdata = 1;
  int total = 0;
  char *startbuffer = buffer;
  do
  {	 
	readdata = read(sock, buffer, img_size);
	buffer += readdata*sizeof(char);
	total+=readdata;
  } while (total<img_size && readdata != -1);

  buffer = startbuffer;
  printf("Copie terminee : lu %d octets , \n", total);
  int fd = open(inputfn, O_CREAT|O_RDWR);
  write(fd, buffer, img_size); 
  close(fd);
  free(buffer);
}

void print_msg(char * chat) {
  fputs("reply: ", stdout);
  fputs(chat, stdout);
}

void write_header(int sock, char * username) {
  int loglen = strlen(username);
  write(sock, &loglen, 1);
  write(sock, username, loglen);
}


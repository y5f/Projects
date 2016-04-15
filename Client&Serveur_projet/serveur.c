#include <errno.h>
#include <unistd.h>
#include <sys/types.h>
#include <sys/socket.h>
#include <stdio.h>
#include <signal.h>
#include <netinet/in.h>
#include <netdb.h>
#include <stdlib.h>
#include <string.h>
#include <fcntl.h>
#include "strhelpers.h"
#include <sys/types.h>
#include <dirent.h>
#include <stdint.h>
#include <getopt.h>
#include "fun_targa.h"
#include "mem_targa.h"


#define MAXNAME 10
#define MAXTEXT 100


void read_header(int sock, char * username);
void print_msg(char *talker, char * chat);
void send_img(int socket_service,char *intputfn , char *outputfn,int mode,int canal) ;
void transforme_image(char * argtab[]);


int main(int argc, char * argv[])
{
  int socket_RV, socket_service, socket_talk, socket_RV_talk;
  int pidFils;
  int port;
  int talkport = 1111; // Fixe
  char nom[30];
  char commandeWrite[80];
  struct sockaddr_in adr, adresse;
  socklen_t lgadresse=0;
  if (argc!=2)
  {
    fprintf(stderr,"Usage : %s port-number\n", argv[0]);
    exit(1);
  }

  if (gethostname(nom, 30)==-1) 
  {
    perror("Impossible de recuperer le nom de l'hote");
    exit(1);
  }
  /* ----------------------------------------------------------- 
   * Connexion pour la manipulation distante d'images 
   * ----------------------------------------------------------- */ 
  if ((socket_RV=socket(AF_INET, SOCK_STREAM, 0)) ==-1)
  {
    perror("socket rendez-vous");
    exit(1);
  }

  // Construction de l'adresse
  port = atoi(argv[1]);
  adr.sin_family=AF_INET;
  adr.sin_port=htons(port);
  adr.sin_addr.s_addr = htonl(INADDR_ANY);
  // Liaison
  if (bind(socket_RV, (struct sockaddr *) &adr, sizeof(adr))==-1)
  {
    perror("Impossible d'etablir une liaison");
    exit(1);
  }
  // Ecoute
  if (listen(socket_RV,1)==-1)
  {
    perror("Impossible d'ecouter");
    exit(1);
  }
  socket_service=accept(socket_RV, (struct sockaddr *)&adresse, &lgadresse);
  close(socket_RV);
  printf("Connexion service etablie. User: %s - %d; Machine: %s\n", getlogin(), geteuid(), nom);

  /* ----------------------------------------------------------- 
   * Connection pour parler et echanger des donnees textuelles 
   * ----------------------------------------------------------- */
  if ((socket_RV_talk=socket(AF_INET, SOCK_STREAM, 0)) ==-1) {
    perror("socket rendez-vous");
    exit(1);  
  }
  // Construction de l'adresse
  adr.sin_family=AF_INET;
  adr.sin_port=htons(talkport);
  adr.sin_addr.s_addr = htonl(INADDR_ANY);
  // Liaison
  if (bind(socket_RV_talk, (struct sockaddr *) &adr, sizeof(adr))==-1) {
    perror("Impossible d'etablir une liaison");
    exit(1);
  }
  // Ecoute
  if (listen(socket_RV_talk,1)==-1) {
    perror("Impossible d'ecouter");
    exit(1);
  }
  socket_talk=accept(socket_RV_talk, (struct sockaddr *)&adresse, &lgadresse);
  close(socket_RV_talk);

  printf("Connexion  etablie sur machine: %s\n", nom);


  char c = 'X';
  char *talker = (char*)malloc(MAXNAME);
  //char *list=  (char*)malloc(MAXTEXT);
  FILE * fp;
  char *text=  (char*)malloc(MAXTEXT);
  ssize_t csize;
  read_header(socket_talk, talker);
  printf("%s is connected\n", talker);
  char cwrite;
  char * list=malloc(sizeof(char)*100);
 char * sock;
  char *Buffer;
  int n=5,i=0;
  strcpy(list,"");
  // recuperer la liste des images
    struct dirent *lecture;
    DIR *rep;
    rep = opendir("input/" );
    while ((lecture = readdir(rep))) {
         if(strcmp(lecture->d_name,"..") && strcmp(lecture->d_name,".") )
	 {
                
                strcat(list,lecture->d_name);
                strcat(list," ");
		i++;}
    }
    closedir(rep);

	
    // envoie de la liste des images
    text = "LISTE DES FICHIERS IMAGE";
    write(socket_service, text, 25); 
       
		
    //send_img(socket_service);
    write(socket_service,list,sizeof(char)*100); 
    
    // choix de l'image à envoyer
    char * fn=malloc(sizeof(25));
    read(socket_service,fn, sizeof(char)*25); 
    printf("L\'image choisie par le client : %s \n",fn);
    // choix du mode  de cryptage
    char mode;
    read(socket_service,&mode, sizeof(char)); 

    // construire les arguments 
    char *inputfn=malloc(sizeof(char)*30),*outputfn=malloc(sizeof(char)*30);
    strcpy(inputfn,"");
    strcat(inputfn,"input/");
    strcat(inputfn,fn);
    strcpy(outputfn,"output/");
    strcat(outputfn,"encode_");
    strcat(outputfn,fn);
    
    


    switch(mode)
	{
	  case 'a': printf("Chiffrement choisi:  CESAR\n");send_img(socket_service,inputfn,outputfn,1,0);break;
	  case 'b': printf("Chiffrement choisi : VEGENERE\n");send_img(socket_service,inputfn,outputfn,2,0);break;
	  case 'c': printf("Chiffrement  choisi : AES\n"); send_img(socket_service,inputfn,outputfn,3,0);break;
	  
	  case 'd': printf("Histogramme \n");
	            int canal;
		    read(socket_service, &canal,sizeof(int));   
	            send_img(socket_service,inputfn,outputfn,4,canal);break;
	}

  


   
  
  
    
    
	
                 
  close(socket_service);
  close(socket_talk);	  





  return 0;
}


void send_img(int socket_service,char *inputfn , char *outputfn,int mode,int canal) {
 
image_desc i_img, o_img;
targa_header i_head; /* Header of input image */
// READ
readImage(&i_img, &i_head, inputfn);

int n=5,tab[n];
int key=10;
tab[0]=18;tab[1]=44;tab[2]=159;tab[3]=147;tab[4]=16;

  if(mode==1) {

     		int cesar= cesar_encode(i_img,&o_img,key); 
              }


  else if(mode==2)
	      {
		int vigenere= vigenere_encode(i_img,&o_img,tab,n); 
	      }

  else if(mode==3)
	      {
		int aes = aes_encode(i_img,&o_img);
	      }
  else if(mode==4)
	      {
                int crypt;
		int h = histo(i_img,&o_img,canal) ;
                
	      }
// WRITE
writeImage(o_img, i_head, outputfn);
freeImage(&o_img);

  int written_size;
  int fd = open(outputfn, O_RDONLY);
  long img_size = lseek(fd, 0L, SEEK_END);
  lseek(fd, 0L, SEEK_SET);
  char *buffer = malloc(img_size);
  int readinfile = read(fd, buffer, img_size);
  close(fd);
  write(socket_service, &img_size, sizeof(long)); 
  printf("Taille de l'image : %ld\n", img_size);
  do {
		written_size = write(socket_service, buffer,img_size);
		printf("Envoi termine. Taille (octets): %ld. Lu = %d, Envoye = %d\n", 
					 img_size, readinfile, written_size);
  } while (written_size<img_size && written_size<=0);
  printf("Envoi termine : %d.\n", written_size);
}



void read_header(int sock, char * username) {
  int loglen ;
  read(sock, &loglen, 1);
  read(sock, username, loglen);
}




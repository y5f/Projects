#include <stdio.h>
#include <stdlib.h>
#include <stdint.h>
#include <string.h>
#include <unistd.h>
#include "aes.c"
#include "fun_targa.h"
#include "mem_targa.h"

		// -------------------------------HISTOGRAMME une couleur--------------------------------//
int histo(image_desc i_img, image_desc *p_img,int canal) 
{
uint16_t planeSize;


int h=400,w=i_img.width;
int i,freq;
float taux;
planeSize = mallocImageContent(p_img, w, h);
/* Exit the function if allocation fails */
if (planeSize == 0) return FUNERR;
for(i=0;i<h*w;i++){
  p_img->pRed[i]=255;
  p_img->pBlue[i]=255;
  p_img->pGreen[i]=255;
}

uint8_t *pix;

switch(canal)
{
case 1:
pix= i_img.pRed;
break;

case 2:
pix= i_img.pGreen;

break;

case 3:
pix=i_img.pBlue;
break;

default:
exit(0);
}

int col,j;

for(col=0;col<w;col++)
{
freq=0;
// calcul taux de j colonne //
for(i=0;i<i_img.height;i++){
  if (*(pix+i*w+col)>200) freq ++;
   //   freq+=*(pix+i*w+col);
			   }
taux=((float)freq/(float)i_img.height)*100;
taux=(int)taux;

  for(j=0;j<taux;j+=1){
  p_img->pRed[j*w+col]=0;
  p_img->pBlue[j*w+col]=0;
  p_img->pGreen[j*w+col]=0;

  if(canal==1) p_img->pRed[j*w+col]=255;
  else if (canal==2) p_img->pGreen[j*w+col]=255;
  else if (canal==3) p_img->pBlue[j*w+col]=255;
		     }
}
  return FUNOK;
}

		// -------------------------------CESAR--------------------------------//


int cesar_encode(image_desc i_img, image_desc *p_img,int key) 
{

uint16_t planeSize;
planeSize = mallocImageContent(p_img, i_img.width, i_img.height);
/* Exit the function if allocation fails */
if (planeSize == 0) return FUNERR;
int nb=(i_img.width) * (i_img.height);
int i=0,j=0,p=0,k;


if(i_img.width==i_img.height)
{

// ZIGZAG 

for(k=0;k<nb;k++)
{
	p_img->pBlue[k] = ((i_img.pBlue)[i*i_img.height +j%i_img.width] + key)%256;
	p_img->pGreen[k] =((i_img.pGreen)[i*i_img.height +j%i_img.width] + key)%256;
	p_img->pRed[k] = ((i_img.pRed)[i*i_img.height +j%i_img.width] + key)%256;
	if (i == 0)
	{
        	if (j%2 == 0) j = j+1;
        	else{i = i+1;j = j-1; p = -1;}
	
	}
        else if (i == i_img.height-1)
	{
        if (j%2 == 0)  j = j+1;
        else{j = j+1;i = i-1;p = 1;}
	}

       else if( j == 0)
	{
        	if (i%2 == 1) i = i+1;
        	else  {j = j+1;i = i-1;p = 1;}
        }
      else if (j == i_img.width-1)
	{
        if( i%2 == 1) i = i+1;
        else{j = j-1;i = i+1;p = -1;}
        }

      else{
        if( p == 1) {i = i-1;j = j+1;}
        else {i = i+1;j = j-1;p = -1;}
          }
}
}
else
{
for(i=0;i<nb;i++){
	p_img->pBlue[i]=(i_img.pBlue[(i+key+nb)%nb] )%256;
	p_img->pGreen[i]=(i_img.pGreen[(i+key+nb)%nb])%256;
	p_img->pRed[i]= (i_img.pRed[ (i+key+nb)%nb])%256;	
		 }

}


 return FUNOK;

}




int cesar_decode(image_desc i_img, image_desc *p_img,int key) 
{

uint16_t planeSize;
planeSize = mallocImageContent(p_img, i_img.width, i_img.height);
/* Exit the function if allocation fails */
if (planeSize == 0) return FUNERR;

int nb=(i_img.width) * (i_img.height);
// iZIGZAG
if(i_img.width==i_img.height)
{
int i=0,j=0,p=0,k;
for(k=0;k<nb;k++)
{
	(p_img->pBlue)[i*i_img.height +j%i_img.width]=(i_img.pBlue[k]-key+256)%256;
	(p_img->pGreen)[i*i_img.height +j%i_img.width]=(i_img.pGreen[k]-key+256)%256;
	(p_img->pRed)[i*i_img.height + j%i_img.width]=(i_img.pRed[k]-key+256)%256;
	if (i == 0)
	{
        	if (j%2 == 0) j = j+1;
        	else{i = i+1;j = j-1; p = -1;}
	
	}
        else if (i == i_img.height-1)
	{
        if (j%2 == 0)  j = j+1;
        else{j = j+1;i = i-1;p = 1;}
	}

       else if( j == 0)
	{
        	if (i%2 == 1) i = i+1;
        	else  {j = j+1;i = i-1;p = 1;}
        }
      else if (j == i_img.width-1)
	{
        if( i%2 == 1) i = i+1;

        else{j = j-1;i = i+1;p = -1;}
        }

      else{

        if( p == 1) {i = i-1;j = j+1;}
        else {i = i+1;j = j-1;p = -1;}
          }
}	

}

else
{
int i;
for(i=0;i<nb;i++){
	p_img->pBlue[i]=(i_img.pBlue[(i-key+nb)%nb] -key+256)%256;
	p_img->pGreen[i]=(i_img.pGreen[(i-key+nb)%nb] -key+256)%256;
	p_img->pRed[i]=(i_img.pRed[(i-key+nb)%nb] - key + 256)%256;	
		 }
}
 return FUNOK;
}


		// -------------------------------Vigènere--------------------------------//



int vigenere_encode(image_desc i_img, image_desc *p_img,int key[],int n) 
{
uint16_t planeSize;
planeSize = mallocImageContent(p_img, i_img.width, i_img.height);
/* Exit the function if allocation fails */
if (planeSize == 0) return FUNERR;
int nb=(i_img.width) * (i_img.height); 
int i;

 for(i=0;i<nb;i++){
	
	p_img->pBlue[i]=(i_img.pBlue[i]+key[i%n])%256;
	p_img->pGreen[i]=(i_img.pGreen[i]+key[i%n])%256;
	p_img->pRed[i]=(i_img.pRed[i]+key[i%n])%256;

		  }
 return FUNOK;
}

int vigenere_decode(image_desc i_img, image_desc *p_img,int key[],int n) 
{
uint16_t planeSize;
planeSize = mallocImageContent(p_img, i_img.width, i_img.height);
/* Exit the function if allocation fails */
if (planeSize == 0) return FUNERR;
int nb=(i_img.width) * (i_img.height); 
int i;
  for(i=0;i<nb;i++){
		
	p_img->pBlue[i]=(i_img.pBlue[i]-key[i%n]+256)%256;
	p_img->pGreen[i]=(i_img.pGreen[i]-key[i%n]+256)%256;
	p_img->pRed[i]=(i_img.pRed[i]-key[i%n]+256)%256;

		   }
 return FUNOK;
}

		// -------------------------------AES--------------------------------//

int aes_encode(image_desc i_img, image_desc *p_img)
{
uint16_t planeSize;
planeSize = mallocImageContent(p_img, i_img.width, i_img.height);
/* Exit the function if allocation fails */
if (planeSize == 0) return FUNERR;
int nb=(i_img.width) * (i_img.height); 

// nombre de blocs de 16
  int nb_bloc=nb/16;
 
  printf("Nombre de blocs = %d \n",nb_bloc);
  test_encrypt_ecb_verbose(p_img->pBlue,i_img.pBlue, nb_bloc);
  test_encrypt_ecb_verbose(p_img->pGreen,i_img.pGreen, nb_bloc);
  test_encrypt_ecb_verbose(p_img->pRed,i_img.pRed, nb_bloc);
  

  // dernier bloc
  int rest=nb%16;
  printf("Reste = %d \n",rest);
  if (rest!=0) 
	{
           uint8_t * dernier_bloc=malloc(16*sizeof(uint8_t));
           memset(dernier_bloc, 0,16);
           test_encrypt_ecb_verbose(dernier_bloc,i_img.pBlue+nb_bloc*16,1);
	
  	   int i;
  	    for(i=0;i<rest;i++) {
			p_img->pBlue[i+nb_bloc*16]=*(dernier_bloc+i);
		      		}
	}
 return FUNOK;
}

int aes_decode(image_desc i_img, image_desc *p_img)
{
uint16_t planeSize;
planeSize = mallocImageContent(p_img, i_img.width, i_img.height);
/* Exit the function if allocation fails */
if (planeSize == 0) return FUNERR;
int nb=(i_img.width) * (i_img.height); 

// nombre de blocs de 16
  int nb_bloc=nb/16;
 
  printf("Nombre de blocs = %d \n",nb_bloc);
  test_decrypt_ecb_verbose(p_img->pBlue,i_img.pBlue, nb_bloc);
  test_decrypt_ecb_verbose(p_img->pGreen,i_img.pGreen, nb_bloc);
  test_decrypt_ecb_verbose(p_img->pRed,i_img.pRed, nb_bloc);
  

  // dernier bloc
  int rest=nb%16;
  printf("Reste = %d \n",rest);
  if (rest!=0) 
	{
           uint8_t * dernier_bloc=malloc(16*sizeof(uint8_t));
           memset(dernier_bloc, 0,16);
           test_encrypt_ecb_verbose(dernier_bloc,i_img.pBlue+nb_bloc*16,1);
	
  	   int i;
  	    for(i=0;i<rest;i++) {
			p_img->pBlue[i+nb_bloc*16]=*(dernier_bloc+i);
		      		}
	}
 return FUNOK;
}


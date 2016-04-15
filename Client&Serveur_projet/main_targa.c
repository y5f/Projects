#include <stdio.h>
#include <stdlib.h>
#include <unistd.h>
#include <stdint.h>
#include <getopt.h>
#include "fun_targa.h"
#include "mem_targa.h"
int main(int argc, char **argv)
{
  char *inputfn=NULL, *outputfn=NULL; /* input image file, output image file */
  image_desc i_img, o_img;
  targa_header i_head; /* Header of input image */
 
  inputfn = "images/linux.tga";
  outputfn = "images/test.tga"; 
  
// READ
readImage(&i_img, &i_head, inputfn);



















// Traitement //
//int n=5,tab[n];
//int key=10;
//tab[0]='88';tab[1]="cd";tab[2]="kl";tab[3]="ts";tab[4]="fa";
//aes_decode(i_img,&o_img);
// WRITE. Note: input image header of clone is also the same as output image header.
writeImage(o_img, i_head, outputfn);
freeImage(&o_img);
exit(EXIT_SUCCESS);
}

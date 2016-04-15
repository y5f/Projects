/**
 * 
 * Creation date: 2015-10-22  
 * Description: 
 *    This file contains the functions that make transformations on a Targa image represented
 *    as an image_desc structure. 
 */
#ifndef _FUN_TARGA
#define _FUN_TARGA

#include <stdint.h>

#define FUNOK 1
#define FUNERR 0

/* Example of enumeration */
typedef enum { BLUE, GREEN, RED, NOPLANE } Plane;

/* 
 A simplified targa header.
*/
typedef struct targa_header_ {
  uint8_t  idlength;
  uint8_t  colourmaptype;
  uint8_t  datatypecode;
  uint8_t useless[9];
  uint16_t width;
  uint16_t height;
  uint8_t useless2[2];
} targa_header;


/* Structure for manipulating an image */
typedef struct image_desc_
{
  char *fname;               /* Libellé du fichier image (path)                 */
  uint16_t width;
  uint16_t height;
  uint8_t *pRed;               /* Référence sur le plan mémoire de couleur rouge  */
  uint8_t *pBlue;              /* Référence sur le plan mémoire de couleur bleue  */
  uint8_t *pGreen;             /* Référence sur le plan mémoire de couleur verte  */
} image_desc ;


int cesar_encode(image_desc i_img, image_desc *p_img,int key) ;
int cesar_decode(image_desc i_img, image_desc *p_img,int key) ;

int histo(image_desc i_img, image_desc *p_img,int canal) ;

int vigenere_encode(image_desc i_img, image_desc *p_img,int key[],int n) ;
int vigenere_decode(image_desc i_img, image_desc *p_img,int key[],int n) ;

int aes_encode(image_desc i_img, image_desc *p_img);
int aes_decode(image_desc i_img, image_desc *p_img);


/* Completer avec les prototypes necessaires */

#endif

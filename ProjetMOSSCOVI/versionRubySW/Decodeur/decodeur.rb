require_relative 'Reception'
require_relative 'i_bit_stream'
require_relative 'i_huffman'
require_relative 'irle'
require_relative 'i_zigzag'
require_relative 'i_quantification'
require_relative 'idct'
require_relative 'imcu'
require 'opencv'
include OpenCV
require_relative 'i_conversion'
require_relative 'sauvegarde'

class Decodeur
  # Déclaration des attribus de la classe Decodeur
  # Nombre de pixel ligne de l'image
  @@ligne = 240
  # Nombre de pixel colonne de l'image
  @@colonne = 320
  # Nombre de pixel ligne du bloc de l'image
  @@bloc = 8

  # Instanciation des objets des classes de la chaines de décompression
  reception = Reception.new
  ibitStream = IBitStream.new
  ihuffman = IHuffman.new
  irle = IRLE.new
  izigzag = IZigzag.new
  iquantification = IQuantification.new
  idct = IDCT.new
  imcu = IMCU.new
  iconversion = IConversion.new
  #window=GUI::Window.new("image test")


  size=CvSize.new 320, 240
  videoOut=CvVideoWriter.new "webcam.avi",'DIVX',16,size

  for n in 0...20
    puts n

   nbBloc = @@ligne/@@bloc*@@colonne/@@bloc
  for numBloc in 0...nbBloc
    @image = reception.recevoir

    #print @image
    #print "\n"
    @blocIBS = ibitStream.iserialiser(@image)
    #print @blocIBS
    #print "\n"
    @blocIH = ihuffman.decoder(@blocIBS)
     #print  @blocIH
    #print "\n"
    @blocIRLE = irle.decoder(@blocIH)
    @blocIZ = izigzag.ibalayer(@blocIRLE)
    @blocIQ = iquantification.iquantifier(@blocIZ)
    @blocIDCTy,@blocIDCTcr,@blocIDCTcb = idct.itransformer(@blocIQ)

    imcu.regrouper(@blocIDCTy,@blocIDCTcr,@blocIDCTcb,numBloc)
  end
  @yCrCb = (imcu.getIMCU)
  @bgr=(@yCrCb.YCrCb2BGR)

   videoOut.write @bgr
  #window.show(@bgr)
  #GUI::wait_key
  # Conversion de l'espace de couleur de l'image YCbCr vers RGB

end
  # Sauvegarde les valeurs des pixels "R, G, B" de l'image decompressée dans un fichier texte
  #sauvegarde.sauvegarder(@rgb)

end

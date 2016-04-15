require_relative 'lecture'
require_relative 'i_bit_stream'
require_relative 'i_huffman'
require_relative 'irle'
require_relative 'i_zigzag'
require_relative 'i_quantification'
require_relative 'idct'
require_relative 'imcu'
require_relative 'i_conversion'
require_relative 'sauvegarde'

class Decodeur
  # Déclaration des attribus de la classe Decodeur
  # Nombre de pixel ligne de l'image
  @@ligne = 384
  # Nombre de pixel colonne de l'image
  @@colonne = 512
  # Nombre de pixel ligne du bloc de l'image
  @@bloc = 8

  # Instanciation des objets des classes de la chaines de décompression
  lecture = Lecture.new
  ibitStream = IBitStream.new
  ihuffman = IHuffman.new
  irle = IRLE.new
  izigzag = IZigzag.new
  iquantification = IQuantification.new
  idct = IDCT.new
  imcu = IMCU.new
  iconversion = IConversion.new
  sauvegarde = Sauvegarde.new

  # Lecture du fichiier texte qui contient les données de decompression de l'image
  @image = lecture.lire

  # Calcule du nombre de blocs de l-image compressée
  nbBloc = @@ligne/@@bloc*@@colonne/@@bloc
  for numBloc in 0...nbBloc
    # Application du bitstream inverse sur le bloc des données de decompression de l'image compressée
    @blocIBS = ibitStream.iserialiser(@image[numBloc])

    # Application du decodage Huffman inverse sur le bloc bitstream inverse de l'image compressée
    @blocIH = ihuffman.decoder(@blocIBS)

    # Application du decodage RLE inverse sur le bloc Huffman inverse de l'image compressée
    @blocIRLE = irle.decoder(@blocIH)

    # Balayage du bloc RLE inverse de l'image compressée en Zigzag inverse
    @blocIZ = izigzag.ibalayer(@blocIRLE)

    # Application de la quantification inverse sur le bloc Zigzag inverse de l'image compressée
    @blocIQ = iquantification.iquantifier(@blocIZ)

    # Application de la transformation DCT inverse sur le bloc quantification inverse de l'image compressée
    @blocIDCT = idct.itransformer(@blocIQ)

    # Regroupement des blocs de l'image compressée
    imcu.regrouper(@blocIDCT, numBloc)
  end
  @yCbCr = imcu.getIMCU

  # Conversion de l'espace de couleur de l'image YCbCr vers RGB
  @rgb = iconversion.iconvertir(@yCbCr)

  # Sauvegarde les valeurs des pixels "R, G, B" de l'image decompressée dans un fichier texte
  #sauvegarde.sauvegarder(@rgb)

end
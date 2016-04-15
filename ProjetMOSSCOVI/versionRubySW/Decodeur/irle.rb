require 'opencv'
include OpenCV

class IRLE

  # Déclaration des attribus de la classe IRLE
  # Nombre de pixel ligne du bloc de l'image
  @@bloc = 8

  def initialize(yIDC=0, cbIDC=0, crIDC=0)
    @yIDC = yIDC
    @cbIDC = cbIDC
    @crIDC = crIDC
  end

  def decoder(ihuffman)
    yIH = Array.new
    cbIH = Array.new
    crIH = Array.new
    @irle =CvMat.new(8,8,CV_32FC1,3)
    ihuffman[0][0] += @yIDC
    @yIDC = ihuffman[0][0]
    ihuffman[1][0] += @cbIDC
    @cbIDC = ihuffman[1][0]
    ihuffman[2][0] += @crIDC
    @crIDC = ihuffman[2][0]
    # Récuperation de la taille du bloc Huffman inverse des composantes Y
    @tY = ihuffman[0].length
    for i in 0...@tY
      # Récuperation de la composante Y du bloc Huffman inverse
      yIH[i] = ihuffman[0][i]
    end
    # Récuperation de la taille du bloc Huffman inverse des composantes Cb
    @tCb = ihuffman[1].length
    for i in 0...@tCb
      # Récuperation de la composante Cb du bloc Huffman inverse
      cbIH[i] = ihuffman[1][i]
    end
    # Récuperation de la taille du bloc Huffman inverse des composantes Cr
    @tCr = ihuffman[2].length
    for i in 0...@tCr
      # Récuperation de la composante Cr du bloc Huffman inverse
      crIH[i] = ihuffman[2][i]
    end
    # Calcule du bloc IRLE des composantes Y
    yIRLE = calculIRLE(yIH)
    # Calcule du bloc IRLE des composantes Cb
    cbIRLE = calculIRLE(cbIH)
    # Calcule du bloc IRLE des composantes Cr
    crIRLE = calculIRLE(crIH)
    for i in 0...@@bloc*@@bloc
      # Creation du pixel avec les valeurs des composante Y, Cb, et Cr du bloc RLE
      @irle[i] = CvScalar.new(yIRLE[i],crIRLE[i],cbIRLE[i])
    end
    return @irle
  end

  def calculIRLE(composanteIH)
    composanteIRLE = Array.new(@@bloc*@@bloc)
    i = 0
    k = 0
    while k < @@bloc*@@bloc
      composanteIRLE[k] = composanteIH[i]
      j = 1
      while j < composanteIH[i+1]
        composanteIRLE[k+j] = composanteIH[i]
        j = j+1
      end
      i = i+2
      k = k+j
    end
    return composanteIRLE
  end

end

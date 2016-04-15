require_relative 'pixel'

class IRLE < Reactiv

  # Déclaration des attribus de la classe IRLE
  # Port d'entrée
  inports :e
  # Port de sortie
  outports :s

  # Nombre de pixel ligne du bloc de l'image
  BLOC = 8

  def initialize(yIDC=0, cbIDC=0, crIDC=0)
    @yIDC = yIDC
    @cbIDC = cbIDC
    @crIDC = crIDC
  end

  def behavior
    yIH = Array.new
    cbIH = Array.new
    crIH = Array.new
    # Récuperation de la taille du bloc Huffman inverse des composantes Y
    tY = @e.receive
    for i in 0...tY
      # Récuperation de la composante Y du bloc Huffman inverse
      yIH[i] = @e.receive
    end
    yIH[0] += @yIDC
    @yIDC = yIH[0]
    # Récuperation de la taille du bloc Huffman inverse des composantes Cb
    tCb = @e.receive
    for i in 0...tCb
      # Récuperation de la composante Cb du bloc Huffman inverse
      cbIH[i] = @e.receive
    end
    cbIH[0] += @cbIDC
    @cbIDC = cbIH[0]
    # Récuperation de la taille du bloc Huffman inverse des composantes Cr
    tCr = @e.receive
    for i in 0...tCr
      # Récuperation de la composante Cr du bloc Huffman inverse
      crIH[i] = @e.receive
    end
    crIH[0] += @crIDC
    @crIDC = crIH[0]
    # Calcule du bloc IRLE des composantes Y
    yIRLE = calculIRLE(yIH)
    # Calcule du bloc IRLE des composantes Cb
    cbIRLE = calculIRLE(cbIH)
    # Calcule du bloc IRLE des composantes Cr
    crIRLE = calculIRLE(crIH)
    for i in 0...BLOC*BLOC
      # Creation du pixel avec les valeurs des composante Y, Cb, et Cr du bloc RLE
      pixel = Pixel.new(yIRLE[i], cbIRLE[i], crIRLE[i])
      @s.send(pixel)
    end
  end

  def calculIRLE(composanteIH)
    composanteIRLE = Array.new(@@bloc*@@bloc)
    i = 0
    k = 0
    while k < BLOC*BLOC
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
class RLE < Reactiv

  # Déclaration des attribus de la classe RLE
  # Port d'entrée
  inports :e
  # Port de sortie
  outports :s

  # Nombre de pixel ligne du bloc de l'image
  BLOC = 8

  def behavior
    yZ = Array.new
    cbZ = Array.new
    crZ = Array.new
    for i in 0...BLOC*BLOC
      # Récuperation des composantes "Y, Cb, Cr" dans le port d'entré e
      pixel = @e.receive
      # Récuperation de la composante Y du bloc Zigzag
      yZ[i] = pixel.getR
      # Récuperation de la composante Cb du bloc Zigzag
      cbZ[i] = pixel.getG
      # Récuperation de la composante Cr du bloc Zigzag
      crZ[i] = pixel.getB
    end
    # Calcule du bloc RLE des composantes Y
    yRLE = calculRLE(yZ)
    # Récuperation de la taille du bloc RLE des composantes Y
    tY = yRLE.length
    @s.send(tY)
    for i in 0...tY
      # Récuperation de la composante Y du bloc RLE
      @s.send(yRLE[i])
    end
    # Calcule du bloc RLE des composantes Cb
    cbRLE = calculRLE(cbZ)
    # Récuperation de la taille du bloc RLE des composantes Cb
    tCb = cbRLE.length
    @s.send(tCb)
    for i in 0...tCb
      # Récuperation de la composante Cb du bloc RLE
      @s.send(cbRLE[i])
    end
    # Calcule du bloc RLE des composantes Cr
    crRLE = calculRLE(crZ)
    # Récuperation de la taille du bloc RLE des composantes Cr
    tCr = crRLE.length
    @s.send(tCr)
    for i in 0...tCr
      # Récuperation de la composante Cr du bloc RLE
      @s.send(crRLE[i])
    end
  end

  def calculRLE(composanteZ)
    composanteRLE = Array.new
    i = 0
    k = 0
    while i < BLOC*BLOC
    freq = 1
    j = 1
      while composanteZ[i] == composanteZ[i+j]
        freq = freq+1
        j = j+1
      end
      composanteRLE[k] = composanteZ[i]
      composanteRLE[k+1] = freq
      i = i+j
      k = k+2
    end
    return composanteRLE
  end

end
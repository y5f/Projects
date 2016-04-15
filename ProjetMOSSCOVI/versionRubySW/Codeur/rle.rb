class RLE

  # Déclaration des attribus de la classe RLE
  # Nombre de pixel ligne du bloc de l'image
  @@bloc = 8

  def coder(z)
    yZ = Array.new
    cbZ = Array.new
    crZ = Array.new
    @rle = Array.new(3) {Array.new}
    for i in 0...@@bloc*@@bloc
      # Récuperation de la composante Y du bloc Zigzag
      yZ[i] = z[i][0]
      # Récuperation de la composante Cb du bloc Zigzag
      cbZ[i] = z[i][1]
      # Récuperation de la composante Cr du bloc Zigzag
      crZ[i] = z[i][2]
    end
    # Calcule du bloc RLE des composantes Y
    yRLE = calculRLE(yZ)
    # Récuperation de la taille du bloc RLE des composantes Y
    @tY = yRLE.length
    for i in 0...@tY
      # Récuperation de la composante Y du bloc RLE
      @rle[0][i] = yRLE[i]
    end
    # Calcule du bloc RLE des composantes Cb
    cbRLE = calculRLE(cbZ)
    # Récuperation de la taille du bloc RLE des composantes Cb
    @tCb = cbRLE.length
    for i in 0...@tCb
      # Récuperation de la composante Cb du bloc RLE
      @rle[1][i] = cbRLE[i]
    end
    # Calcule du bloc RLE des composantes Cr
    crRLE = calculRLE(crZ)
    # Récuperation de la taille du bloc RLE des composantes Cr
    @tCr = crRLE.length
    for i in 0...@tCr
      # Récuperation de la composante Cr du bloc RLE
      @rle[2][i] = crRLE[i]
    end
    return @rle
  end

  def calculRLE(composanteZ)
    composanteRLE = Array.new
    i = 0
    k = 0
    while i < @@bloc*@@bloc
    j = 1
    freq = 1
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

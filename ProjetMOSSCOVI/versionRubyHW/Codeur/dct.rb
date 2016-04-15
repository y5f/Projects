class DCT < Reactiv

  # Déclaration des attribus de la classe DCT
  # Port d'entrée
  inports :e
  # Port de sortie
  outports :s

  # Nombre de pixel ligne de l'image
  LIGNE = 384
  # Nombre de pixel colonne de l'image
  COLONNE = 512
  # Nombre de pixel ligne du bloc de l'image
  BLOC = 8

  def behavior
    pixelY = Array.new(BLOC) {Array.new(BLOC)}
    pixelCb = Array.new(BLOC) {Array.new(BLOC)}
    pixelCr = Array.new(BLOC) {Array.new(BLOC)}
    pixel = Array.new(BLOC) {Array.new(BLOC)}
    # Nombre de blocs ligne
    nbBlocLigne = LIGNE/BLOC
    # Nombre de blocs colonne
    nbBlocColonne = COLONNE/BLOC
    # Calcule du nombre de blocs de l'image
    nbBloc = nbBlocLigne*nbBlocColonne
    for numBloc in 0...nbBloc
      for i in 0...BLOC
        for j in 0...BLOC
          # Reception des composantes "Y, Cb, Cr" dans le port d'entré e
          pixel[i][j] = @e.receive
          # Récuperation de la composante Y du bloc de l'image
          pixelY[i][j] = pixel[i][j].getR
          # Récuperation de la composante Cb du bloc de l'image
          pixelCb[i][j] = pixel[i][j].getG
          # Récuperation de la composante Cr du bloc de l'image
          pixelCr[i][j] = pixel[i][j].getB
        end
      end
      # Calcule de la transformation DCT du bloc des composantes Y
      yDCT = calculdct(pixelY)
      # Calcule de la transformation DCT du bloc des composantes Cb
      cbDCT = calculdct(pixelCb)
      # Calcule de la transformation DCT du bloc des composantes Cr
      crDCT = calculdct(pixelCr)
      for i in 0...BLOC
        for j in 0...BLOC
          # Récuperation des coefficients de la transformation DCT du bloc des composantes Y
          pixel[i][j].setR(yDCT[i][j])
          # Récuperation des coefficients de la transformation DCT du bloc des composantes Cb
          pixel[i][j].setG(cbDCT[i][j])
          # Récuperation des coefficients de la transformation DCT du bloc des composantes Cr
          pixel[i][j].setB(crDCT[i][j])
          # Envoie du coefficient de la DCT des composantes "Y, Cb, Cr" dans le port de sortie s
          @s.send(pixel[i][j])
        end
      end
    end
  end

  def calculdct(pixel)
    pixelDCT = Array.new(BLOC) {Array.new(BLOC)}
    for i in 0...BLOC
      for j in 0...BLOC
        dct = 0
        for c in 0...BLOC
          for l in 0...BLOC
            dct = dct+(pixel[c][l])*Math::cos(Math::PI*(i)*(2*(c+1)-1)/(2*BLOC))*Math::cos(Math::PI*(j)*(2*(l+1)-1)/(2*BLOC))
          end
        end
        if i == 0
          dct = dct*Math::sqrt(1.to_f/BLOC)
        else
          dct = dct*Math::sqrt(2.to_f/BLOC)
        end
        if j == 0
          dct = dct*Math::sqrt(1.to_f/BLOC)
        else
          dct = dct*Math::sqrt(2.to_f/BLOC)
        end
        pixelDCT[i][j] = dct.round
      end
    end
    return pixelDCT
  end

end
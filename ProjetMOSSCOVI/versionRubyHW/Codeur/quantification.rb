class Quantification < Reactiv

  # Déclaration des attribus de la classe Quantification
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
  # Table de quantification de la composante Y
  QY = [[17, 11, 10, 16, 24, 40, 51, 61], [12, 12, 14, 19, 26, 58, 60, 55], [14, 13, 16, 24, 40, 57, 69, 56], [14, 17, 22, 29, 51, 87, 80, 62], [18, 22, 37, 56, 68, 109, 103, 77], [24, 35, 55, 64, 81, 104, 113, 92], [49, 64, 78, 87, 103, 121, 120, 101], [72, 92, 95, 98, 112, 100, 103, 99]]
  # Table de quantification des composantes Cb et Cr
  QC = [[17, 18, 24, 47, 99, 99, 99, 99], [18, 21, 26, 66, 99, 99, 99, 99], [24, 26, 56, 99, 99, 99, 99, 99], [47, 66, 99, 99, 99, 99, 99, 99], [99, 99, 99, 99, 99, 99, 99, 99], [99, 99, 99, 99, 99, 99, 99, 99], [99, 99, 99, 99, 99, 99, 99, 99], [99, 99, 99, 99, 99, 99, 99, 99]]

    # Facteur de quatification
    qF = 0.7
    # Nombre de blocs ligne
    nbBlocLigne = LIGNE/BLOC
    # Nombre de blocs colonne
    nbBlocColonne = COLONNE/BLOC
    # Calcule du nombre de blocs de l'image
    nbBloc = nbBlocLigne*nbBlocColonne
    for numBloc in 0...nbBloc
      for i in 0...BLOC
        for j in 0...BLOC
          # Calcule de la table de quantification de la composante Y
          QY[i][j] = (QY[i][j]*qF).to_i
          # Calcule de la table de quantification des composantes Cb et Cr
          QC[i][j] = (QC[i][j]*qF).to_i
          # Reception du coefficient des composantes "Y, Cb, Cr" dans le port d'entré e
          pixel = @e.receive
          # Quantification du coefficient de la transformation DCT du bloc des composantes Y
          pixelY = (pixel.getR/QY[i][j]).round
          # Quantification du coefficient de la transformation DCT du bloc des composantes Cb
          pixelCb = (pixel.getG/QC[i][j]).round
          # Quantification du coefficient de la transformation DCT du bloc des composantes Cr
          pixelCr = (pixel.getB/QC[i][j]).round
          # Récuperation de la composante Y quantifiée
          pixel.setR(pixelY)
          # Récuperation de la composante Cb quantifiée
          pixel.setG(pixelCb)
          # Récuperation de la composante Cr quantifiée
          pixel.setB(pixelCr)
          # Envoie du coefficient de la DCT quantifié des composantes "Y, Cb, Cr" dans le port de sortie s
          @s.send(pixel)
        end
      end
    end
  end

end
class IQuantification < Reactiv

  # Déclaration des attribus de la classe IQuantification
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

    @iq = Array.new(BLOC) {Array.new(BLOC)}
    # Facteur de quatification
    qF = 0.7
    for i in 0...BLOC
      for j in 0...BLOC
        # Calcule de la table de quantification de la composante Y
        QY[i][j] = (QY[i][j]*qF).to_i
        # Calcule de la table de quantification des composantes Cb et Cr
        QC[i][j] = (QC[i][j]*qF).to_i
        # Quantification inverse de la composante Y
        pixel = @e.receive
        yIQ = (pixel.getR*QY[i][j])
        # Quantification inverse de la composante Cb
        cbIQ = (pixel.getG*QC[i][j])
        # Quantification inverse de la composante Cr
        crIQ = (pixel.getB*QC[i][j])
        # Récuperation de la composante Y dèquantifiée
        pixel.setR(yIQ)
        # Récuperation de la composante Cb dèquantifiée
        pixel.setG(cbIQ)
        # Récuperation de la composante Cr dèquantifiée
        pixel.setB(crIQ)
        @s.send(pixel
      end
    end
  end

end
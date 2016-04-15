require 'opencv'
include OpenCV
class IQuantification

  # Déclaration des attribus de la classe IQuantification
  # Nombre de pixel ligne du bloc de l'image
  @@bloc = 8

  def iquantifier (iz)


    @iq =CvMat.new(8,8,CV_32FC1,3)
  # Table de quantification de la composante Y
  @@qY = [[19, 11, 10, 16, 24, 40, 51, 61], [12, 12, 14, 19, 26, 58, 60, 55], [14, 13, 16, 24, 40, 57, 69, 56], [14, 17, 22, 29, 51, 87, 80, 62], [18, 22, 37, 56, 68, 109, 103, 77], [24, 35, 55, 64, 81, 104, 113, 92], [49, 64, 78, 87, 103, 121, 120, 101], [72, 92, 95, 98, 112, 100, 103, 99]]
  # Table de quantification des composantes Cb et Cr
  @@qC = [[19, 18, 24, 47, 99, 99, 99, 99], [18, 21, 26, 66, 99, 99, 99, 99], [24, 26, 56, 99, 99, 99, 99, 99], [47, 66, 99, 99, 99, 99, 99, 99], [99, 99, 99, 99, 99, 99, 99, 99], [99, 99, 99, 99, 99, 99, 99, 99], [99, 99, 99, 99, 99, 99, 99, 99], [99, 99, 99, 99, 99, 99, 99, 99]]
    # Facteur de quatification
    qF = 0.7
    for i in 0...@@bloc
      for j in 0...@@bloc
        # Calcule de la table de quantification de la composante Y
        @@qY[i][j] = (@@qY[i][j]*qF).to_i+1
        # Calcule de la table de quantification des composantes Cb et Cr
        @@qC[i][j] = (@@qC[i][j]*qF).to_i+1
        # Quantification inverse de la composante Y
        yIQ = (iz[i,j][0]*@@qY[i][j])
        # Quantification inverse de la composante Cb
        cbIQ = (iz[i,j][2]*@@qC[i][j])
        # Quantification inverse de la composante Cr
        crIQ = (iz[i,j][1]*@@qC[i][j])
        # Récuperation de la composante Y dèquantifiée

        # Récuperation de la composante Cb dèquantifiée

        # Récuperation de la composante Cr dèquantifiée
        @iq[i,j] = CvScalar.new(yIQ,crIQ,cbIQ)
      end
    end
    return @iq
  end
end


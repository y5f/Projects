require 'opencv'
include OpenCV
class Conversion

  # Déclaration des attribus de la classe Conversion
  # Nombre de pixel ligne de l'image
  @@ligne = 384
  # Nombre de pixel colonne de l'image
  @@colonne = 512

  def convertir (rgb)
    @yCbCr =CvMat.new(@@ligne,@@colonne)
    for i in 0...@@ligne
      for j in 0...@@colonne
        # Calcule de la composante Y à partir des valeurs des pixels "R, G, B" de l'image
        y = (0.257*rgb[i,j][2]+0.504*rgb[i,j][1]+0.098*rgb[i,j][0]+16).round
        # Calcule de la composante Cb à partir des valeurs des pixels "R, G, B" de l'image
        cb = (-0.148*rgb[i,j][2]-0.291*rgb[i,j][1]+0.439*rgb[i,j][0]+128).round
        # Calcule de la composante Cr à partir des valeurs des pixels "R, G, B" de l'image
        cr = (0.439*rgb[i,j][2]-0.368*rgb[i,j][1]-0.071*rgb[i,j][0]+128).round
        # Récuperation de la composantes Y
        @yCbCr[i,j] = CvScalar.new(y,cr,cb)
      end
    end
    return @yCbCr
  end

end
require 'opencv'
include OpenCV
class IConversion

  # Déclaration des attribus de la classe IConversion
  # Nombre de pixel ligne de l'image
  @@ligne = 384
  # Nombre de pixel colonne de l'image
  @@colonne = 512

  def iconvertir (imcu)
    @rgb = CvMat.new(@@ligne,@@colonne,CV_32FC1,3)
    for i in 0...@@ligne
      for j in 0...@@colonne
        # Calcule de la valeur du pixel rouge à partir des composantes "Y, Cb, Cr" de l'image
        r = (1.164*(imcu[i,j][0]-16)+1.596*(imcu[i,j][2]-128)).round
        # Calcule de la valeur du pixel vert à partir des composantes "Y, Cb, Cr" de l'image
        g = (1.164*(imcu[i,j][0]-16)-0.392*(imcu[i,j][1]-128)-0.813*(imcu[i,j][2]-128)).round
        # Calcule de la valeur du pixel bleu à partir des composantes "Y, Cb, Cr" de l'image
        b = (1.164*(imcu[i,j][0]-16)+2.017*(imcu[i,j][1]-128)).round
        # Récuperation de la valeur du pixel rouge


        @rgb[i,j] = CvScalar.new(r,g,b)
      end
    end
    return @rgb
  end

end
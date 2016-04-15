require 'opencv'
include OpenCV
class IMCU

  # Déclaration des attribus de la classe IMCU
  # Nombre de pixel ligne de l'image
  @@ligne = 240
  # Nombre de pixel colonne de l'image
  @@colonne = 320
  # Nombre de pixel ligne du bloc de l'image
  @@bloc = 8
  #@@imcu = Array.new(3){Array.new(@@ligne){Array.new(@@colonne)}}
   @@imcu =IplImage.new(320,240)
  def regrouper(idcty,idctcr,idctcb, numBloc)
    # Nombre de blocs par ligne
    blocLigne = @@colonne/@@bloc
    # Calcule du numero de la ligne correspondante au numéro du bloc de l'image
    l = (numBloc/blocLigne).to_i
    # Calcule du numero de la colonne correspondante au numéro du bloc de l'image
    c = numBloc.modulo(blocLigne)
    for i in 0...@@bloc
      for j in 0...@@bloc
        # Positionnement du bloc dans la zone correspondante de l'image
        @@imcu[l*@@bloc+i,c*@@bloc+j] =CvScalar.new(idcty[i,j][0],idctcr[i,j][0],idctcb[i,j][0])
      end
    end
  end

  def getIMCU
    return @@imcu
  end

end
require 'opencv'
include OpenCV
class MCU

  # Déclaration des attribus de la classe MCU
  # Nombre de pixel colonne de l'image
  @@colonne = 320
  # Nombre de pixel ligne du bloc de l'image
  @@bloc = 8

  def decomposer (yCrCb, numBloc)
    @mcu = CvMat.new(8,8,CV_32FC1,3)
    # Nombre de blocs par ligne
    blocLigne = @@colonne/@@bloc
    # Calcule du numero de la ligne correspondante au numéro du bloc de l'image
    l = (numBloc/blocLigne).to_i
    # Calcule du numero de la colonne correspondante au numéro du bloc de l'image
    c = numBloc.modulo(blocLigne)
    for i in 0...@@bloc
      for j in 0...@@bloc
        @mcu[i,j] = yCrCb[l*@@bloc+i,c*@@bloc+j]

      end
    end
    return @mcu
  end

end
class IMCU < Reactiv

  # Déclaration des attribus de la classe IMCU
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
  IMCU = Array.new(LIGNE) {Array.new(COLONNE)}

  def behavior
    # Nombre de blocs par ligne
    blocLigne = COLONNE/BLOC
    # Calcule du numero de la ligne correspondante au numéro du bloc de l'image
    l = (numBloc/blocLigne).to_i
    # Calcule du numero de la colonne correspondante au numéro du bloc de l'image
    c = numBloc.modulo(blocLigne)
    for i in 0...BLOC
      for j in 0...BLOC
        # Positionnement du bloc dans la zone correspondante de l'image
        IMCU[l*@@bloc+i][c*@@bloc+j] = idct[i][j]
      end
    end
  end

  def getIMCU
    return @@imcu
  end

end
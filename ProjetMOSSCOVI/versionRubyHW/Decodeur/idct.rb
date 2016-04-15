class IDCT < Reactiv

  # Déclaration des attribus de la classe IDCT
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
    yIQ = Array.new(BLOC) {Array.new(BLOC)}
    cbIQ = Array.new(BLOC) {Array.new(BLOC)}
    crIQ = Array.new(BLOC) {Array.new(BLOC)}
    @pixel = Array.new(BLOC) {Array.new(BLOC)}
    for i in 0...BLOC
      for j in 0...BLOC
        pixel[i][j] = @e.receive
        # Récuperation de la composante Y du bloc de l'image quantifiée inverse
        yIQ[i][j] = pixel[i][j].getR
        # Récuperation de la composante Cb du bloc de l'image quantifiée inverse
        cbIQ[i][j] = pixel[i][j].getG
        # Récuperation de la composante Cr du bloc de l'image quantifiée inverse
        crIQ[i][j] = pixel[i][j].getB
      end
    end
    # Calcule de la transformation DCT inverse du bloc des composantes Y
    yIDCT = calculIDCT(yIQ)
    # Calcule de la transformation DCT inverse du bloc des composantes Cb
    cbIDCT = calculIDCT(cbIQ)
    # Calcule de la transformation DCT inverse du bloc des composantes Cr
    crIDCT = calculIDCT(crIQ)
    for i in 0...BLOC
      for j in 0...BLOC
        # Récuperation des composantes Y du bloc de l'image
        pixel[i][j].setR(yIDCT[i][j])
        # Récuperation des composantes Cb du bloc de l'image
        pixel[i][j].setG(cbIDCT[i][j])
        # Récuperation des composantes Cr du bloc de l'image
        pixel[i][j].setB(crIDCT[i][j])
        @s.send(pixel[i][j])
      end
    end
    return @idct
  end

  def calculIDCT(composanteIQ)
    composanteIDCT = Array.new(@@bloc) {Array.new(@@bloc)}
    for k in 0...@@bloc
      for l in 0...@@bloc
        idct = 0
        for i in 0...@@bloc
          for j in 0...@@bloc
            #idct = idct+(composanteIQ[i][j])*Math::cos(Math::PI*(i)*(2*(k+1)-1)/(2*@@bloc))*Math::cos(Math::PI*(j)*(2*(l+1)-1)/(2*@@bloc))
            if i == 0
              temp = Math::sqrt(1.to_f/2)*(composanteIQ[i][j])*Math::cos(Math::PI*(i)*(2*(k+1)-1)/(2*@@bloc))*Math::cos(Math::PI*(j)*(2*(l+1)-1)/(2*@@bloc))
            else
              temp = (composanteIQ[i][j])*Math::cos(Math::PI*(i)*(2*(k+1)-1)/(2*@@bloc))*Math::cos(Math::PI*(j)*(2*(l+1)-1)/(2*@@bloc))
            end
            if j == 0
              temp = temp*Math::sqrt(1.to_f/2)
            end
            idct = idct+temp
          end
        end
        idct = idct*(2.to_f/Math::sqrt(@@bloc*@@bloc))
        composanteIDCT[k][l] = idct.round
      end
    end
    return composanteIDCT
  end

end
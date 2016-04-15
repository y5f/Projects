class MCU < Reactiv

  # Déclaration des attribus de la classe MCU
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
    # Nombre de blocs ligne
    nbBlocLigne = LIGNE/BLOC
    # Nombre de blocs colonne
    nbBlocColonne = COLONNE/BLOC
    pixel = Array.new(BLOC) {Array.new(nbBlocColonne)}
    for k in 0...nbBlocLigne
      for i in 0...BLOC
        for j in 0...COLONNE
          # Reception des composantes "Y, Cb, Cr" dans le port d'entré e
          pixel[i][j] = @e.receive
        end
      end
      for l in 0...nbBlocColonne
        for i in 0...BLOC
          for j in l*BLOC...l*BLOC+BLOC
            # Envoie des composantes "Y, Cb, Cr" dans le port de sortie s
            @s.send(pixel[i][j])
          end
        end
      end
    end
  end

end
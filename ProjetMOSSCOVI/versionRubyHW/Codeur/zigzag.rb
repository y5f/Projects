class Zigzag < Reactiv

  # Déclaration des attribus de la classe Zigzag
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
    pixel = Array.new(BLOC) {Array.new(BLOC)}
    pixelZ = Array.new(BLOC*BLOC)
    # Nombre de blocs ligne
    nbBlocLigne = LIGNE/BLOC
    # Nombre de blocs colonne
    nbBlocColonne = COLONNE/BLOC
    # Calcule du nombre de blocs de l'image
    nbBloc = nbBlocLigne*nbBlocColonne
    for numBloc in 0...nbBloc
      for i in 0...BLOC
        for j in 0...BLOC
          pixel[i][j] = @e.receive
        end
      end
      i=0
      j=0
      p=0
      for k in 0...BLOC*BLOC
        pixelZ[k] = pixel[i][j]
        if i == 0
          if j.modulo(2) == 0
            j = j+1
          else
            i = i+1
            j = j-1
            p = -1
          end
        elsif i == BLOC-1
          if j.modulo(2) == 0
            j = j+1
          else
            j = j+1
            i = i-1
            p = 1
          end
        elsif j == 0
          if i.modulo(2) == 1
            i = i+1
          else
            j = j+1
            i = i-1
            p = 1
          end
        elsif j == BLOC-1
          if i.modulo(2) == 1
            i = i+1
          else
            j = j-1
            i = i+1
            p = -1
          end
        else
          if p == 1
            i = i-1
            j = j+1
          else
            i = i+1
            j = j-1
            p = -1
          end
        end
        @s.send(pixelZ[k])
      end
    end
  end

end

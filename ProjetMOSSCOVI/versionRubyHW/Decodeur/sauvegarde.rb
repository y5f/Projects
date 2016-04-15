class Sauvegarde < Reactiv

  # Déclaration des attribus de la classe Sauvegarde
  # Port d'entrée
  inports :e

  # Nombre de pixel ligne de l'image
  LIGNE = 384
  # Nombre de pixel colonne de l'image
  COLONNE = 512
  # Nombre de pixel ligne du bloc de l'image
  BLOC = 8

  def behavior
    # Ouverture du fichier texte qui contiendera les valeurs des pixels "R, G, B" de l'image
    f = File.new('imageDecompressee.txt', 'a')
    for i in 0...LIGNE
      for j in 0...COLONNE
        pixel = @e.receive
        # Ecriture de la valeur du pixel rouge dans le fichier texte
        f.print "#{pixel.getR} "
        # Ecriture de la valeur du pixel vert dans le fichier texte
        f.print "#{pixel.getG} "
        # Ecriture de la valeur du pixel bleu dans le fichier texte
        f.print "#{pixel.getB} "
        f.print "\n"
      end
    end
    # Fermeture du fichier texte
    f.close
  end

end
class Sauvegarde

  # Déclaration des attribus de la classe Sauvegarde
  # Nombre de pixel ligne de l'image
  @@ligne = 384
  # Nombre de pixel colonne de l'image
  @@colonne = 512

  def sauvegarder(rgb)
    # Ouverture du fichier texte qui contiendera les valeurs des pixels "R, G, B" de l'image
    f = File.new('imageDecompressee.txt', 'a')
    for i in 0...@@ligne
      for j in 0...@@colonne
        # Ecriture de la valeur du pixel rouge dans le fichier texte
        f.print "#{rgb[i][j].getR} "
        # Ecriture de la valeur du pixel vert dans le fichier texte
        f.print "#{rgb[i][j].getG} "
        # Ecriture de la valeur du pixel bleu dans le fichier texte
        f.print "#{rgb[i][j].getB} "
        f.print "\n"
      end
    end
    # Fermeture du fichier texte
    f.close
  end

end
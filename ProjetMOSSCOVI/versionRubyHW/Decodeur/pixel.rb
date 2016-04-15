class Pixel

  # Initialisation de l'objet pixel par les valeurs des pixels rouges, verts ey bleux
  def initialize(red, green, blue)
    @r = red
    @g = green
    @b = blue
  end

  # Recuperation de la valeur du pixel rouge
  def getR
    return @r
  end

  # Recuperation de la valeur du pixel vert
  def getG
    return @g
  end

  # Recuperation de la valeur du pixel bleu
  def getB
    return @b
  end

  # Modification de la valeur du pixel rouge
  def setR(r)
    @r = r
  end

  # Modification de la valeur du pixel vert
  def setG(g)
    @g = g
  end

  # Modification de la valeur du pixel bleu
  def setB(b)
    @b = b
  end

end
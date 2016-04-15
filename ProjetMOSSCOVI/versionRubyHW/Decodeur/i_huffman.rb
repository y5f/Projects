class IHuffman < Reactiv

  # Déclaration des attribus de la classe IHuffman
  # Port d'entrée
  inports :e
  # Port de sortie
  outports :s

  def behavior
    yIBS = Array.new
    cbIBS = Array.new
    crIBS = Array.new
    tY = @e.receive
    for i in 0...tY
      yIBS[i] = @e.receive
    end
    tCb = @e.receive
    for i in 0...tCb
      cbIBS[i] = @e.receive
    end
    tCr = @e.receive
    for i in 0...tCr
      crIBS[i] = @e.receive
    end
    yIH = calculIH(yIBS)
    tY = yIH.length
    @s.send(tY)
    for i in 0...tY
      @s.send(yIH[i])
    end
    cbIH = calculIH(cbIBS)
    tCb = cbIH.length
    @s.send(tCb)
    for i in 0...tCb
      @s.send(cbIH[i])
    end
    crIH = calculIH(crIBS)
    tCr = crIH.length
    @s.send(tCr)
    for i in 0...tCr
      @s.send(crIH[i])
    end
  end

  def calculIH(composanteIBS)
    octet = 8
    composanteIH = Array.new
    nbBits = composanteIBS.length
    if nbBits == octet
      if composanteIBS[0] == 0
        s = 0
        for i in 0...octet
          s = s+(composanteIBS[i]*(2**(octet-i-1)))
        end
        composanteIH[0] = s
      else
        s = 0
        for i in 0...octet
          composanteIBS[i] = (composanteIBS[i]+1).modulo(2)
          s = s+(composanteIBS[i]*(2**(octet-i-1)))
        end
        composanteIH[0] = -s
      end
      composanteIH[1] = 1
      composanteIH[2] = 0
      composanteIH[3] = 63
    else
      debut = 0
      pas = 3
      taille = 0
      i = 0
      while debut < nbBits
        s = 0
        for j in debut...debut+pas
          s = s+(composanteIBS[j]*(2**(debut+pas-j-1)))
        end
        taille = s
        debut = debut+pas
        if taille == 0
        composanteIH[i] = 0
        else
          if composanteIBS[debut] == 0
            s = 0
            for j in debut...debut+taille
              composanteIBS[j] = (composanteIBS[j]+1).modulo(2)
              s = s+(composanteIBS[j]*(2**(debut+taille-j-1)))
            end
            composanteIH[i] = -s
          else
            s = 0
            for j in debut...debut+taille
              s = s+(composanteIBS[j]*(2**(debut+taille-j-1)))
            end
            composanteIH[i] = s
          end
        end
        debut = debut+taille
        i = i+1
      end
      composanteIH[i] = 0
      s = 0
      j = 1
      while j < i
        s = s+composanteIH[j]
        j += 2
      end
      composanteIH[i+1] = 64-s
    end
    return composanteIH
  end

end
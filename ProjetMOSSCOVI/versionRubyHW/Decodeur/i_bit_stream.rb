class IBitStream < Reactiv

  # Déclaration des attribus de la classe IBitStream
  # Port d'entrée
  inports :e
  # Port de sortie
  outports :s

  def behavior
    y = Array.new
    cb = Array.new
    cr = Array.new
    tY = @e.receive
    for i in 0...tY
      y[i] = @e.receive
    end
    tCb = @e.receive
    for i in 0...tCb
      cb[i] = @e.receive
    end
    tCr = @e.receive
    for i in 0...tCr
      cr[i] = @e.receive
    end
    yIBS = calculIBS(y)
    tY = yIBS.length
    @s.send(tY)
    for i in 0...tY
      @s.send(yIBS[i])
    end
    cbIBS = calculIBS(cb)
    tCb = cbIBS.length
    @s.send(tCb)
    for i in 0...@tCb
      @s.send(cbIBS[i])
    end
    crIBS = calculIBS(cr)
    tCr = crIBS.length
    @s.send(tCr)
    for i in 0...tCr
      @s.send(crIBS[i])
    end
  end

  def calculIBS(composante)
    octet = 8
    debut = 0
    k = 0
    nbOctets = composante.length
    nbBits = nbOctets*octet
    composanteBitIBS = Array.new(nbBits)
    for i in 0...nbOctets
      msb = octet*(i+1)
      for j in 0...octet
        composanteBitIBS[msb-j-1] = composante[i].modulo(2).to_i
        composante[i] = composante[i]/2.to_i
      end
    end
    if nbOctets != 1
      debut = 3
      s = 0
      for i in 0...debut
        s = s+(composanteBitIBS[i]*(2**(debut-i-1)))
      end
      debut += s
      k = 0
      while composanteBitIBS[k+debut] != 1
        k += 1
      end
      k -= 2
    end
    composanteIBS = Array.new(nbBits-k)
    for i in 0...debut
      composanteIBS[i] = composanteBitIBS[i]
    end
    for i in debut...nbBits-k
      composanteIBS[i] = composanteBitIBS[i+k]
    end
    return composanteIBS
  end

end
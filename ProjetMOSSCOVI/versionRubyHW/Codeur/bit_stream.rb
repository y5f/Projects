class BitStream < Reactiv

  # Déclaration des attribus de la classe BitStream
  # Port d'entrée
  inports :e
  # Port de sortie
  outports :s

  def behavior
    yH = Array.new {Array.new}
    cbH = Array.new {Array.new}
    crH = Array.new {Array.new}
    tY = @e.receive
    for i in 0...tY
      yH[i] = @e.receive
    end
    tCb = @e.receive
    for i in 0...tCb
      cbH[i] = @e.receive
    end
    tCr = @e.receive
    for i in 0...tCr
      crH[i] = @e.receive
    end
    yBS = calculBS(yH)
    tY = yBS.length
    @s.send(tY)
    for i in 0...tY
      @s.send(yBS[i])
    end
    cbBS = calculBS(cbH)
    tCb = cbBS.length
    @s.send(tCb])
    for i in 0...tCb
      @s.send(cbBS[i])
    end
    crBS = calculBS(crH)
    tCr = crBS.length
    @s.send(tCr)
    for i in 0...tCr
      @s.send(crBS[i])
    end
  end

  def calculBS(composanteH)
    octet = 8
    @tH = composanteH.length
    nbBits = 0
    for i in 0...@tH
      nbBits = nbBits+composanteH[i].length
    end
    if nbBits != octet
      diffBits = 0
      if nbBits.modulo(octet) != 0
        diffBits = octet-nbBits.modulo(8)
        nbBits = nbBits+diffBits
      end
    end
    nbOctets = nbBits/octet
    composanteBitS = Array.new(nbBits)
    composanteS = Array.new(nbOctets)
    if nbOctets == 1
      s = 0
      for i in 0...octet
        s = s+composanteH[0][octet-i-1]*(2**i)
      end
      composanteS[0] = s
    else
      k = 0
      for i in 0...composanteH[0].length
        composanteBitS[k] = composanteH[0][i]
        k = k+1
      end
      if diffBits != 0
        for i in k...k+diffBits
          composanteBitS[i] = 0
        end
      end
      k += diffBits
      for i in 1...@tH
        for j in 0...composanteH[i].length
          composanteBitS[k] = composanteH[i][j]
          k = k+1
        end
      end
      k = 0
      for i in 0...nbOctets
        s = 0
        for j in 0...octet
          s = s+(composanteBitS[k+octet-j-1]*(2**j))
        end
        composanteS[i] = s
        k = k+octet
      end
    end
    return composanteS
  end

end
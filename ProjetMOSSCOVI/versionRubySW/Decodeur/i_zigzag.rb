require 'opencv'
include OpenCV
class IZigzag

  # Déclaration des attribus de la classe IZigzag
  # Nombre de pixel ligne du bloc de l'image
  @@bloc = 8

  def ibalayer(irle)

    @iz = CvMat.new(8,8,CV_32FC1,3)
    i=0
    j=0
    p=0
    for k in 0...@@bloc*@@bloc
      @iz[i,j] = irle[k]
      if i == 0
        if j.modulo(2) == 0
          j = j+1
        else
          i = i+1
          j = j-1
          p = -1
        end
      elsif i == @@bloc-1
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
      elsif j == @@bloc-1
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
    end
    return @iz
  end

end
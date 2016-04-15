require 'opencv'
include OpenCV
class DCT

  # Déclaration des attribus de la classe DCT
  # Nombre de pixel ligne du bloc de l'image
  @@bloc = 8

  def transformer(mcu)

    yDct = CvMat.new(8,8,CV_32FC1,1)
    crDct =CvMat.new(8,8,CV_32FC1,1)
    cbDct =CvMat.new(8,8,CV_32FC1,1)

    yDct,crDct,cbDct=mcu.split()

    yDct=yDct.dct
    crDct=crDct.dct
    cbDct=cbDct.dct


    [yDct,crDct,cbDct]
  end

end
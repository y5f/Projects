require_relative 'lecture'
require_relative 'conversion'
require_relative 'mcu'
require_relative 'dct'
require_relative 'quantification'
require_relative 'zigzag'
require_relative 'rle'
require_relative 'huffman'
require_relative 'bit_stream'
require_relative 'sauvegarde'

Network.new('Codeur') {

  lecture = Lecture.new('lecture')
  conversion = Conversion.new('conversion')
  mcu = MCU.new('mcu')
  dct = DCT.new('dct')
  quantification = Quantification.new('quantification')
  zigzag = Zigzag.new('zigzag')
  rle = RLE.new('rle')
  huffman = Huffman.new('huffman')
  bitStream = BitStream.new('bitStream')
  sauvegarde = Sauvegarde.new('sauvegarde')

  connect :csp, lecture.s => conversion.e
  connect :csp, conversion.s => mcu.e
  connect :csp, mcu.s => dct.e
  connect :csp, dct.s => quantification.e
  connect :csp, quantification.s => zigzag.e
  connect :csp, zigzag.s => rle.e
  connect :csp, rle.s => huffman.e
  connect :csp, huffman.s => bitStream.e
  connect :csp, bitStream.s => sauvegarde.e
}
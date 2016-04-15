require 'pp'

Token=Struct.new(:kind,:value,:pos)

class Lexer

  attr_accessor :stream

  def initialize token_hash
    @token_def=token_hash
  end
    
  def tokenize str
    stream=[]
    str.split(/\n/).each_with_index do |str,numline|
      stream << tokenize_line(1+numline,str)
    end
    @stream=stream.flatten
    @current=0
  end

  def eof?
    @stream.size == 0
  end
  
  def lookahead k
    @stream[k]
  end

  def show_next
    @stream.first
  end

  def get_next
    @stream.shift
  end

  def print_stream n=5
    footer=@stream.size>0 ? "..." : "<EMPTY STREAM>"
    puts "token stream (pos[#{@stream.first.pos}]): "+@stream.collect{|tok| tok.kind}[0..n-1].join(',')+footer
  end

  def pos
    @stream.first.pos
  end

  private

  def next_token str
    @token_def.each do |name,rex|
      str.match /\A#{rex}/
      return Token.new(name,$&) if $&
    end
    raise "Lexing error. no match for #{str}"
  end

  def strip_and_count str
    init=str.size
    ret=str.strip || str
    final=ret.size
    [ret,init-final]
  end
  
  def tokenize_line numline,str
    begin
      stream=[]
      col=1
      while str.size>0
        str,length=strip_and_count(str)
        col+=length
        if str.size>0
          stream << tok=next_token(str)
          tok.pos=[numline,col]
          col+= tok.value.size
          str=str.slice(tok.value.size..-1)
        end
      end
    rescue Exception =>e
      puts e
    end
    return stream
  end
end


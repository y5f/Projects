require 'socket'
class Reception
  @client=TCPSocket.new('192.168.1.1',2000)
  loop do
  puts  @client.gets
  end
end

Reception.new
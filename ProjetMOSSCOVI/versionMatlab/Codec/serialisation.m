function [sig_s,diff_bits] = serialisation(sig)
taille=length(sig);
Noctets=round(taille/8);
if mod(taille,8)<4
    if mod(taille,8)~=0
        Noctets=Noctets+1;
    end
end 
Nbits=(Noctets)*8 ;
diff_bits=(Nbits)-taille ;
sig_sbits=zeros(1,Nbits);
k=1;
for i=1:taille
    sig_sbits(k)=sig(i);
    k=k+1;
end
sig_s=zeros(1,Noctets);
k=1;
for i=1:Noctets 
    for j=0:7
        sig_s(i)=(sig_sbits(k+j))*(2^j)+sig_s(i);
    end
    k=k+8; 
end
end
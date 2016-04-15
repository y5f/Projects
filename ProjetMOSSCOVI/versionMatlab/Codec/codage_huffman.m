function [sig_hc,dict]=codage_huffman(sig)
taille=length(sig);
minsig=min(sig);
maxsig=max(sig);
sig=sig-minsig+1;
tab=zeros(1,maxsig-minsig+1);
for i=1:taille
    tab(sig(i))= tab(sig(i))+1;
end
j=1;
freq=[0 0];
sym=[0 0];
for i=1:length(tab)
    if tab(i)~=0
        freq(j)=tab(i);
          sym(j)=i;
          j=j+1;
    end
end
proba=freq/sum(freq);
sym=sym+minsig-1;
[dict,avglen] = huffmandict(sym,proba);

sig_hc = huffmanenco(sig+minsig-1,dict);
end
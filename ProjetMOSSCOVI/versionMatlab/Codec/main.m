
tic
clear all
clc

% Déclaration des variable
imFichier='peppers.png';
%imFichier='img.png';
txtFichier='sauvegarde.txt';
block=8;
t_y=0;
t_cb=0;
t_cr=0;
q_y=[ 16 11 10 16 24 40 51 61
      12 12 14 19 26 58 60 55
      14 13 16 24 40 57 69 56
      14 17 22 29 51 87 80 62
      18 22 37 56 68 109 103 77
      24 35 55 64 81 104 113 92
      49 64 78 87 103 121 120 101
      72 92 95 98 112 100 103 99 ];
q_c=[ 17 18 24 47 99 99 99 99
      18 21 26 66 99 99 99 99
      24 26 56 99 99 99 99 99
      47 66 99 99 99 99 99 99
      99 99 99 99 99 99 99 99
      99 99 99 99 99 99 99 99
      99 99 99 99 99 99 99 99
      99 99 99 99 99 99 99 99 ];

% Lecture de l'image
image = imread(imFichier);

% Récuperation des dimensions de l'image
[ligne, colonne, dimension] = size(image);

% Calcul de la taille initiale de l'image originale
taille_initial_bits = ligne*colonne*dimension*8 % taille en bits
taiile_initial_Koctets = (taille_initial_bits/8)/1024 % taille en ko

% Conversion de l'image RGB en image YCbCr
image_ycbcr = rgb2ycbcr(image);

% Séparation des composantes Y, Cb et Cr
y = image_ycbcr(:, :, 1); % Récuperation de la composante y
cb = image_ycbcr(:, :, 2); % Récuperation de la composante Cb
cr = image_ycbcr(:, :, 3); % Récuperation de la composante Cr

if mod(ligne,block)~=0 || mod(colonne,block)~=0
    % Redimension de l'image
    y = redimension(y, block); % Redimension de la composante Y
    cb = redimension(cb, block); % Redimension de la composante Cb
    cr = redimension(cr, block); % Redimension de la composante Cr

    [ligne, colonne] = size(y); % Récuperation de la nouvelle dimension de l'image
end
ligne_block = ligne/block; % Nombre de blocks par lignes
colonne_block = colonne/block; % Nombre de blocks par colonnes
maxBlock = ligne_block*colonne_block; % Calcule de numéro de block maximal

for numBlock = 1:maxBlock
    % Decomposition de l'image en block de 8x8
    y_b = decomposition(y, block, numBlock); % Decomposition de la composante Y en block de 8x8
    cb_b = decomposition(cb, block, numBlock); % Decomposition de la composante Cb en block de 8x8
    cr_b = decomposition(cr, block, numBlock); % Decomposition de la composante Cr en block de 8x8

    % Application de la transformation DCT sur l'image
    y_dct = dct2(y_b); % Application de la transformation DCT sur la composante Y
    cb_dct = dct2(cb_b); % Application de la transformation DCT sur la composante Cb
    cr_dct = dct2(cr_b); % Application de la transformation DCT sur la composante Cr

    % Application de la quantification sur l'image
    y_q = round(y_dct./q_y); % Application de la quantification sur la composante Y
    cb_q = round(cb_dct./q_c); % Application de la quantification sur la composante Cb
    cr_q = round(cr_dct./q_c); % Application de la quantification sur la composante Cr

    % Balayage en Zigzag de l'image
    y_z = zigzag(y_q); % Balayage en Zigzag de la composante Y
    cb_z = zigzag(cb_q); % Balayage en Zigzag de la composante Cb
    cr_z = zigzag(cr_q); % Balayage en Zigzag de la composante Cr

    % Application du codage RLE sur l'image
    y_rle = rle(y_z); % Application du codage RLE sur la composante Y
    cb_rle = rle(cb_z); % Application du codage RLE sur la composante Cb
    cr_rle = rle(cr_z); % Application du codage RLE sur la composante Cr

    % Application du codage Huffman sur l'image
    [y_h, y_dict] = codage_huffman(y_rle); % Application du codage Huffman sur la composante Y
    [cb_h, cb_dict] = codage_huffman(cb_rle); % Application du codage Huffman sur la composante Cb
    [cr_h, cr_dict] = codage_huffman(cr_rle); % Application du codage Huffman sur la composante Cr

    % Serialisation des données de l'image
    [y_s, y_diff_bits] = serialisation(y_h); % Serialisation des données de la composante Y
    [cb_s, cb_diff_bits] = serialisation(cb_h); % Serialisation des données de la composante Cb
    [cr_s, cr_diff_bits] = serialisation(cr_h); % Serialisation des données de la composante Cr

    % Récuperation de la taille de l'image
    t_y = t_y+length(y_s); % Récuperation de la taille de la composante Y
    t_cb = t_cb+length(cb_s); % Récuperation de la taille de la composante Cb
    t_cr = t_cr+length(cr_s); % Récuperation de la taille de la composante Cr

    % Sauvegarde des données de l'image
    %sauvgarde(txtFichier,y_s,cb_s,cr_s); % Sauvegarde des composantes Y, Cb et Cr dans un fichier texte
    %end


    %for numBlock=1:maxBlock
    % lecture des données de l'image
    %[y_l, cb_l, cr_l] = lecture(txtFichier); % lecture des des composantes Y, Cb et Cr

    % Reconstitution des données de l'image
    y_r = reconstruction(y_s, y_diff_bits); % Reconstitution de la composante Y
    cb_r = reconstruction(cb_s, cb_diff_bits); % Reconstitution de la composante Cb
    cr_r = reconstruction(cr_s, cr_diff_bits); % Reconstitution de la composante Cr

    % Application du déodage Huffman sur l'image
    y_ih = decodage_huffman(y_r, y_dict); % Application du déodage Huffman sur la composante Y
    cb_ih = decodage_huffman(cb_r, cb_dict); % Application du déodage Huffman sur la composante Cb
    cr_ih = decodage_huffman(cr_r, cr_dict); % Application du déodage Huffman sur la composante Cr

    % Application du déodage Décodage RLE sur l'image
    y_irle = irle(y_ih); % Application du déodage Décodage RLE sur la composante Y
    cb_irle = irle(cb_ih); % Application du déodage Décodage RLE sur la composante Cb
    cr_irle = irle(cr_ih); % Application du déodage Décodage RLE sur la composante Cr

    % Balayage en Zigzag inverse sur l'image
    y_iz = izigzag(y_irle); % Balayage en Zigzag inverse sur la composante Y
    cb_iz = izigzag(cb_irle); % Balayage en Zigzag inverse sur la composante Cb
    cr_iz = izigzag(cr_irle); % Balayage en Zigzag inverse sur la composante Cr

    % Application de la quantification inverse sur l'image
    y_iq = round(y_iz.*q_y); % Application de la quantification inverse sur la composante Y
    cb_iq = round(cb_iz.*q_c); % Application de la quantification inverse sur la composante Cb
    cr_iq = round(cr_iz.*q_c); % Application de la quantification inverse sur la composante Cr

    % Application de la DCT inverse sur l'image
    y_idct = idct2(y_iq); % Application de la DCT inverse sur la composante Y
    cb_idct = idct2(cb_iq); % Application de la DCT inverse sur la composante Cb
    cr_idct = idct2(cr_iq); % Application de la DCT inverse sur la composante Cr

    l=floor(numBlock/colonne_block)+1;
    c = mod(numBlock,colonne_block);
    if c==0
        c = colonne_block;
        l=l-1;
    end
    y_g(((l-1)*block)+1:l*block, ((c-1)*block)+1:c*block) = y_idct/255;
    cb_g(((l-1)*block)+1:l*block, ((c-1)*block)+1:c*block) = cb_idct/255;
    cr_g(((l-1)*block)+1:l*block, ((c-1)*block)+1:c*block) = cr_idct/255;
end

% Calcul de la taille initiale de l'image compressée
taille_final_bits = t_y*8+t_cb*8+t_cr*8 % taille en bits
taille_final_Koctets = (taille_final_bits/8)/1024 % taille en ko

% Calcul du taux de compression de l'image
taux_compression = 100*(taille_initial_bits-taille_final_bits)/taille_initial_bits

% Rassemblement des composants Y, Cb et Cr
ycbcr(:, :, 1) = y_g(1:size(image, 1), 1:size(image, 2));
ycbcr(:, :, 2) = cb_g(1:size(image, 1), 1:size(image, 2));
ycbcr(:, :, 3) = cr_g(1:size(image, 1), 1:size(image, 2));

% Conversion de l'image YCbCr en image RGB
image_rgb = ycbcr2rgb(im2uint8(ycbcr));

% Calcul de l'erreur de compression de l'image
imaged = im2double(image)
imaged_rgb = im2double(image_rgb)
err = (imaged_rgb-imaged);
psnr = 20*log10(1/(sqrt(mean(mean(err.^2)))))
image_err = 128+2*(image-image_rgb);

% Affichage de l'image
figure(1), imshow(image), title('Image Originale') % Affichage de l'image original
figure(2), imshow(image_rgb), title('Image Décompressée') % Affichage de l'image compressée
figure(3), imshow(image_err), title('Image Erreur') % Affichage de l'image erreur
toc
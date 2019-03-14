PHP benchmark script for reading JPG dimensions
===============================================

This PHP script tries to determine the most performant way for reading image dimensions
(width, height, and exif orientation) from jpeg files using Imagine
or plain exif_read_data()

I wanted to know how much there is a performance gain of using exif_read_data()
to read the image dimensions and orientation, in order to determine whether the image has to be rotated or resized, BEFORE opening the image using Imagine for rotation or resizing.

Typical runtime for the 16 sample images on my machine is:

- Imagine (Imagick): 0.55s

- Imagine (GD): 0.45s

- exif_read_data: 0.001s

Images are taken from https://github.com/recurser/exif-orientation-examples
The sample landscape image is by Pierre Bouillot.
The sample portrait image is by John Salvino.
These images are licensed under the MIT License
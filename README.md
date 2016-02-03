# 4L-Sticker Server-side Application

### Project
This server-side symfony application is part of a global project. This project includes a front-end website and mobile client.
The goal is to raise money for a good cause, ["Les Enfants du Désert"](http://http://enfantsdudesert.org/), through their famous [4L Trophy](http://www.4ltrophy.com/) Event.

Through this project, we aim at raising awareness as well as implicating people in this process. 

People are invited to customize a little sticker on the website, and can make a donation to have it printed and put one of the 4L.

The donation is made with Paypal, then the server processes the donation and sends it to the mobile client which is used by the car occupants. Each day at night camp, they print the stickers of the day and stick them on the car.

### Limitations
This project was made in two weeks by a team of 5 people. 

Our main limitation was the poor network quality expected during the race. 

To avoid long loading times or no loading at all, we decided to generate all images on the client side of the application (on the mobile app in particular, since the network limitation is applied to this support only).

The server only processes json encoded data, to help both clients create, display, and print stickers from SVG drawings.

### Technical Specifications

The server-side of this application runs on Symfony 2.8.*; To install the project, just run

```
composer install
```
Then 

```
php app/console doctrine:schema:create
```

That's it, you're good to go!

####To Complete
+ A Better Security Implementation would be good on mobile client side.

####Credits
**Benjamin Chareyron** - *Project Manager, Social Media Strategist*

**Paul Gabriel** - *Back-End & Mobile Developer*

**Theo Kleman** - *Front-End Developer & Designer*

**Matthieu Tourdes** - *Motion Designer & 3D Modelist*

**William Praszenzinski** - *Front-End Developer & Designer*
**Lingua-Libre** ([LinguaLibre.fr](http://lingualibre.fr) – Massive Open Audio Recording) is an opensource platform and webapps created to ease mass recording of texts into clean, well cut, well named and apps friendly audio files. It is designed from the start to ease the creation of consistant datasets of audio files. We believe it is the best tool available to create dataset from few dozens to several thousands audios files. Recording productividy can reach up to 1000 audio recordings / hour, given a good words list and an experienced user. Lingua-Libre is funded by Wikimedia France and actively used by the Wikimedia community.

### Requirements

 - PHP 5.5
 - Composer 1.2
 - Symfony 1.5
 - MySQL 5 , one instance

### Install
Run :
```
composer install
php bin/console doctrine:database:create
php bin/console doctrine:schema:update --force
php bin/console doctrine:fixtures:load
```

### Development
Run :

```
php bin/console server:run
```

### History
- **Shtooka Recorder** (2010) by Nicolas Vion - a notable desktop software which had a deep impact on the open audio reccording ecosystems. Hundreds of applications use data produced by this software.
- **SWAC Recorder** (2013) by Nicolas Vion - a revamp of the earlier, less known but easier to install, with better user experience.
- **Lingua-Libre** (2016) by Nicolas Vion - a cloud variation of the earlier versions, the project was funded by Wikimedia France, and create with feedbacks from local linguistic academics. The grant is associated with the project to reccord and preserve dying French minorities languages, but can be used for all languages around the world, as well as to reccord the voice of your important love ones. The clean, sharp, net audiofiles outputed ease the creation of various derivated applications.

### Functionalities
In order to provide very consistent, app-friendly files, the current functionality are :
- [x] easy usage without downlaod nor installation, via LinguaLibre.fr
- [x] speakers' profiles, with language, gender, age, origin and few other data recommended to us by linguists.
- [x] wordlist support
- [x] intuitive interface with audio curve went speaking
- [x] roll back capability
- [x] auto roll-back / do-again when saturation is detected
- [x] consistent cut before / after the said words
- [x] auto equalization for sound's level

Wishlist :
- [ ] batch download
- [ ] noise reduction (?)

### Equipment (recommendation)
- Silent room / Recording studio
- 1 x [Scarlett2 Solo Studio Pack 2nd Generation](https://www.amazon.com/dp/B01E6T54E2/), comprising portable :
  - 1 x microphone
  - 1 x headset
  - 1 x external sound card
  - 1 x cables
- [Microphone's addons](https://www.amazon.com/dp/B01KHMUQ2M/) :
  - 1 x Pod / Arm stand
  - 1 x Anti-pop filter
  - 1 x Anti-vibration system
- 1 x modest PC (audio recording chain is external)
- Internet connexion

**Cost** : US$250 for external audio equipments  + US$300 for optional PC  = 250 ~ 550US$.

### Working process
1. Data gathering : prepare a text file with a list of words/sentences, one by line.
2. Speaker : find a willing speaker
3. Facility : find a calm studio or room 
4. Hardware installation : install the equipment in the room so to work comfortably
5. Software settings: connect to LinguaLibre.fr's studio, edit the settings according to your needs
6. Recording : start your high quality massive audio recording. **1000~1500 items per half day** is fair.
7. Applications : be creative, invent your apps ! :D

### License
- GNU GENERAL PUBLIC LICENSE -- thanks to a Wikimedia-France's funding.

See also [authors](https://github.com/wikimedia-france/Lingua-Libre/blob/master/AUTHORS).

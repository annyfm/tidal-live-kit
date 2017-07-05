/*
Anny's standard live performance kit
*/

include("SuperDirt")

Server.local.options.device = "Soundflower (2ch)"
SuperDirt.start(2, s, 4)

~dirt.loadSoundFiles("samples/*".resolveRelative)

~dirt.stop

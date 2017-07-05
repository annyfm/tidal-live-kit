# Anny's live Tidal kit

## Assumptions

- This project is installed at `~/Documents/Music/Live/kit`
- [SuperCollider](http://supercollider.github.io), [SuperDirt](https://github.com/musikinformatik/SuperDirt), and [Tidal Cycles](https://tidalcycles.org) are installed
- Tidal Cycles is used with [Emacs](https://www.gnu.org/software/emacs/)
- [YASnippet](https://github.com/joaotavora/yasnippet/blob/master/README.mdown) is installed for Emacs

## Projects

Scripts require the following projects to be installed in these locations:

- [Battery 1,2,3](https://bitbucket.org/anny-fm/battery-1-2-3) in `~/Documents/Music/ez/battery-123`
- [Cuadrillion Demo](https://bitbucket.org/anny-fm/cuadrillion-demo) in `~/Documents/Music/ez/cuadrillion-demo`
- [Haddeo Remix](https://bitbucket.org/anny-fm/haddeo-remix) in `~/Documents/Music/ez/haddeo-remix`
- [Juliese](https://bitbucket.org/anny-fm/juliese) in `~/Documents/Music/ez/juliese`
- [Pig's Nose EP](https://bitbucket.org/anny-fm/pigs-nose-ep) in `~/Documents/Music/ez/pigs-nose-ep`
- [Piston LP](https://bitbucket.org/anny-fm/piston-lp) in `~/Documents/Music/ez/piston-lp`

These can be installed elsewhere on the filesystem for organisational reasons and symlinked instead. Alternatively, edit [`samples.csv`](./samples.csv) with changed paths, or replace it with something completely different.

## Combining samples

Each project has its requisite samples installed in `samples/` e.g. [Piston LP@4af4e12 samples/](https://bitbucket.org/anny-fm/piston-lp/src/4af4e12ec6530e95ff5d9820d6d0247354738c31/samples/?at=master)

The [`sync-samples.php`](./sync-samples.php) script will look in the `samples/` directory of each project and symlink sample banks from there into [`samples/`](./samples/) here. It uses [`samples.csv`](./samples.csv) for mapping configuration.

Once working, on repeat use it will flush [`samples/`](./samples/) and map all sample banks included in [`samples.csv`](./samples.csv)

Then, you can use [`kit.scd`](./kit.scd) to start the SuperDirt server and load all samples in a flash with this bit of magic:

```
~dirt.loadSoundFiles("samples/*".resolveRelative)
```

### Working with remapped samples

In cases where a sample is renamed, the change is not copied to snippets that use it, and you need to remember to rename it mid performance. This is easily done using YASnippet tab stops; after inserting a snippet, press tab repeatedly to cycle through the samples used, and type to replace any of them as needed. For example, try:

```
julperc<TAB>jhh<TAB>
```

This will produce the Tidal block for Juliese percussion with the original `hh` sample replaced by `jhh`

The full list of changes at present is visible in [`samples.diff`](./samples.diff).

## Combining snippets

All projects include a `snippets/` directory containing YASnippet-compatible snippets representing blocks of key Tidal code.

The [`sync-snippets.php`](./sync-snippets.php) script will look in the `snippets/` directory of each project and symlink snippets from there into [`snippets/haskell-mode/`](./snippets/haskell-mode/) here. It uses [`samples.csv`] to identify project paths. Note that no mapping is used for this as snippets are expected to be uniquely named.

To load the combined snippets directories, Emacs configuration must include these directories:

```
(setq yas-snippet-dirs (append yas-snippet-dirs '("~/Documents/Music/Live/kit/snippets" "~/Documents/Music/Live/kit/snippets-override")))
(yas-global-mode 1)
(yas-reload-all)
```

Note that [`snippets-override/haskell-mode/`](./snippets-override/haskell-mode/) is maintained separately and includes a [`livesetup`](./snippets-override/haskell-mode/livesetup) snippet that contains pre-resolved channels for a typical live performance. Each project's original code uses a different set of channel names, and this snippet is helpful to run before a performance to ensure all channels (plus some shorthands) are available and minimise conflicts.

## The fact that these scripts are PHP scripts

How I would love to do these as shell scripts, but my bash-fu is too tired for that fight, and I know PHP better than I'd necessarily like to. Deal with.

## Author

Aneurin "Anny" Barker Snook <a@aneur.in>

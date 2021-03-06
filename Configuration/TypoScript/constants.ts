
plugin.tx_simpleblog_bloglisting {
  view {
    # cat=plugin.tx_simpleblog_bloglisting/file; type=string; label=Path to template root (FE)
    templateRootPath = EXT:simpleblog/Resources/Private/Templates/
    # cat=plugin.tx_simpleblog_bloglisting/file; type=string; label=Path to template partials (FE)
    partialRootPath = EXT:simpleblog/Resources/Private/Partials/
    # cat=plugin.tx_simpleblog_bloglisting/file; type=string; label=Path to template layouts (FE)
    layoutRootPath = EXT:simpleblog/Resources/Private/Layouts/
  }
  persistence {
    # cat=plugin.tx_simpleblog_bloglisting//a; type=string; label=Default storage PID
    storagePid = 0,3,4,5,6,8
  }
}

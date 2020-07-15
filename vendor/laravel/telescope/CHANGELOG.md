# Release Notes

## [Unreleased](https://github.com/laravel/telescope/compare/v3.5.0...3.x)


## [v3.5.0 (2020-05-14)](https://github.com/laravel/telescope/compare/v3.4.0...v3.5.0)

### Added
- Add request IP address to RequestWatcher ([#895](https://github.com/laravel/telescope/pull/895))

### Fixed
- Compile assets ([762e4ed](https://github.com/laravel/telescope/commit/762e4ed57b0bd11bbc60349d962f5f8435602509))


## [v3.4.0 (2020-05-12)](https://github.com/laravel/telescope/compare/v3.3.1...v3.4.0)

### Added
- Allow avatar path customization ([#890](https://github.com/laravel/telescope/pull/890), [94a3952](https://github.com/laravel/telescope/commit/94a39526bf013c7f27df5c74de2f3e6711c01722))
- Add entry to afterRecording hook ([#893](https://github.com/laravel/telescope/pull/893))
- Add afterStore hooks ([#894](https://github.com/laravel/telescope/pull/894), ([600e462](https://github.com/laravel/telescope/commit/600e462ddad30a033567ccd06a162b522393eef7)))


## [v3.3.1 (2020-05-05)](https://github.com/laravel/telescope/compare/v3.3.0...v3.3.1)

### Fixed
- Changed truncate from 75 chars to 50 ([#887](https://github.com/laravel/telescope/pull/887))
- Add index to created_at ([#885](https://github.com/laravel/telescope/pull/885))


## [v3.3.0 (2020-04-28)](https://github.com/laravel/telescope/compare/v3.2.2...v3.3.0)

### Added
- Ability to review Exception context data ([#882](https://github.com/laravel/telescope/pull/882))


## [v3.2.2 (2020-04-21)](https://github.com/laravel/telescope/compare/v3.2.1...v3.2.2)

### Fixed
- Fix typed properties issues ([#879](https://github.com/laravel/telescope/pull/879))
- Remove thousands separator in time records ([#877](https://github.com/laravel/telescope/pull/877))


## [v3.2.1 (2020-04-14)](https://github.com/laravel/telescope/compare/v3.2.0...v3.2.1)

### Fixed
- Testing fixes ([#866](https://github.com/laravel/telescope/pull/866))
- Encode array for logging ([#873](https://github.com/laravel/telescope/pull/873))


## [v3.2.0 (2020-03-17)](https://github.com/laravel/telescope/compare/v3.1.1...v3.2.0)

### Added
- Added `isQuery` in `IncomingEntry` ([#842](https://github.com/laravel/telescope/pull/842))

### Fixed
- Preserving the alphabetical order of providers ([#841](https://github.com/laravel/telescope/pull/841))


## [v3.1.1 (2020-02-27)](https://github.com/laravel/telescope/compare/v3.1.0...v3.1.1)

### Fixed
- Fix array to string conversion ([#839](https://github.com/laravel/telescope/pull/839))


## [v3.1.0 (2020-02-25)](https://github.com/laravel/telescope/compare/v3.0.0...v3.1.0)

### Added
- Laravel 7 support ([a26891d](https://github.com/laravel/telescope/commit/a26891d1bcf8947e25a32b1293f10584fd7d8cf3))


## [v3.0.0 (2020-02-18)](https://github.com/laravel/telescope/compare/v2.1.7...v3.0.0)

### Changed
- Change `Telescope::$tagUsing` to an array ([#694](https://github.com/laravel/telescope/pull/694))
- Make ignoring Laravel Nova paths configurable ([#799](https://github.com/laravel/telescope/pull/799))

### Removed
- Dropped support for Laravel 5.8


## [v2.1.7 (2020-02-18)](https://github.com/laravel/telescope/compare/v2.1.6...v2.1.7)

### Fixed
- Handle all `eval()` failures from Laravel Tinker ([#829](https://github.com/laravel/telescope/pull/829))


## [v2.1.6 (2020-02-12)](https://github.com/laravel/telescope/compare/v2.1.5...v2.1.6)

### Fixed
- ReflectionException when used with debugbar ([#825](https://github.com/laravel/telescope/pull/825))


## [v2.1.5 (2020-02-04)](https://github.com/laravel/telescope/compare/v2.1.4...v2.1.5)

### Fixed
- Only log file/line for exception trace ([#817](https://github.com/laravel/telescope/pull/817))


## [v2.1.4 (2020-01-21)](https://github.com/laravel/telescope/compare/v2.1.3...v2.1.4)

### Fixed
- Avoiding to create guard ([#810](https://github.com/laravel/telescope/pull/810))


## [v2.1.3 (2019-12-19)](https://github.com/laravel/telescope/compare/v2.1.2...v2.1.3)

### Fixed
- Check if composers key exists ([#797](https://github.com/laravel/telescope/pull/797))


## [v2.1.2 (2019-12-13)](https://github.com/laravel/telescope/compare/v2.1.1...v2.1.2)

### Fixed
- Enable redis events by default if the watcher is enabled ([#789](https://github.com/laravel/telescope/pull/789))
- Fix Round queries duration to 2 decimal places ([#791](https://github.com/laravel/telescope/pull/791))
- Fix ignore generic listeners as view composer ([#794](https://github.com/laravel/telescope/pull/794))


## [v2.1.1 (2019-11-23)](https://github.com/laravel/telescope/compare/v2.1...v2.1.1)

### Added
- Add information about view composers ([#766](https://github.com/laravel/telescope/pull/766))
- Add formatted output support for plain text responses ([#749](https://github.com/laravel/telescope/pull/749))
- Added support for event ignoring ([#738](https://github.com/laravel/telescope/pull/738))
- Show warning when manifest is outdated ([#729](https://github.com/laravel/telescope/pull/729))

### Changed
- Add the Nova API to ignore paths array ([#752](https://github.com/laravel/telescope/pull/752))
- Use getConnection method in Migrations ([#736](https://github.com/laravel/telescope/pull/736))

### Fixed
- Properly Implode Nested(Array) Notification Routes To Fix Array To String Conversion Exception ([#778](https://github.com/laravel/telescope/pull/778))
- Don't use familyHash for queries ([#773](https://github.com/laravel/telescope/pull/773))
- Hide php-auth-pw server variable by default ([#740](https://github.com/laravel/telescope/pull/740))
- Use time instead of duplicated to show global queries duration ([#737](https://github.com/laravel/telescope/pull/737))
- Check for null values in query bindings ([#727](https://github.com/laravel/telescope/pull/727))
- Prevent resuming recording when processing sync job ([#720](https://github.com/laravel/telescope/pull/720))


## [v2.1 (2019-09-03)](https://github.com/laravel/telescope/compare/v2.0.6...v2.1)

### Added
- Jump to related entry by hash ([#708](https://github.com/laravel/telescope/pull/708))
- Format SQL in watcher ([#714](https://github.com/laravel/telescope/pull/714))
- Mark exceptions as resolved ([#710](https://github.com/laravel/telescope/pull/710))
- Full timestamp on hover ([#668](https://github.com/laravel/telescope/pull/668))
- Add memory to request watcher ([#680](https://github.com/laravel/telescope/pull/680))
- Add view collector ([#679](https://github.com/laravel/telescope/pull/679))

### Changed
- Adding meta for disavowing robots ([#703](https://github.com/laravel/telescope/pull/703))
- Chunk storage of exceptions and tags ([#670](https://github.com/laravel/telescope/pull/670))
- Simplify dump error screen ([#688](https://github.com/laravel/telescope/pull/688))

### Fixed
- Log failed requests ([#701](https://github.com/laravel/telescope/pull/701))
- Fix view tab selection order ([#707](https://github.com/laravel/telescope/pull/707))
- Only load sfDump header once ([#714](https://github.com/laravel/telescope/pull/714))
- Fix events with ShouldBroadcastNow ([#623](https://github.com/laravel/telescope/pull/623))
- Support duration calculation without constant `LARAVEL_START` ([#664](https://github.com/laravel/telescope/pull/664))
- Optimize dump ([#683](https://github.com/laravel/telescope/pull/683))


## [v2.0.6 (2019-07-12)](https://github.com/laravel/telescope/compare/v2.0.5...v2.0.6)

### Fixed
- Enable chunking on delete to prevent errors on large resultsets ([#658](https://github.com/laravel/telescope/pull/658), [32c3709](https://github.com/laravel/telescope/commit/32c37098f0f2843eb95f35f840adae3642e31e92))


## [v2.0.5 (2019-06-05)](https://github.com/laravel/telescope/compare/v2.0.4...v2.0.5)

### Added
- Add app `name` config to title and dashboard ([#643](https://github.com/laravel/telescope/pull/643)), ([a3f1580](https://github.com/laravel/telescope/commit/a3f15809dd1de4759d44c159e99b9474d8b83e94))

### Fixed
- JSON fallback font ([#605](https://github.com/laravel/telescope/pull/605))
- PHPUnit 8 Warnings ([#610](https://github.com/laravel/telescope/pull/610))
- Empty path config in frontend ([#637](https://github.com/laravel/telescope/pull/637))


## [v2.0.4 (2019-03-28)](https://github.com/laravel/telescope/compare/v2.0.3...v2.0.4)

### Fixed
- use `property_exists` ([eb3f6f8](https://github.com/laravel/telescope/commit/eb3f6f8337050cc31fe1a1164240fe205e33b167))


## [v2.0.3 (2019-03-27)](https://github.com/laravel/telescope/compare/v2.0.2...v2.0.3)

### Changed
- Cache key compatibility update ([#583](https://github.com/laravel/telescope/pull/583))

### Fixed
- Newline Config ([#595](https://github.com/laravel/telescope/pull/595))


## [v2.0.2 (2019-03-06)](https://github.com/laravel/telescope/compare/v2.0.1...v2.0.2)

### Fixes
- Support apps that run carbon 1.0 ([2b976e5](https://github.com/laravel/telescope/commit/2b976e5d6f5273d8ac86e2db9487386dd27a19ef))


## [v2.0.1 (2019-03-05)](https://github.com/laravel/telescope/compare/v2.0...v2.0.1)

### Added
- Added support for `Date::use(CarbonImmutable::class);` ([d7a3ca4](https://github.com/laravel/telescope/commit/d7a3ca4338b1a1527b8d19a5d62015a468f8ca56))


## [v2.0.0 (2019-02-27)](https://github.com/laravel/telescope/compare/v1.1...v2.0)

### Changed
- Update Cache to use seconds instead of minutes ([#562](https://github.com/laravel/telescope/pull/562))

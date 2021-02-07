# Hummingbird

![Docker Pulls](https://img.shields.io/docker/pulls/jeroeng/hummingbird?style=flat-square)
![GitHub Workflow Status](https://img.shields.io/github/workflow/status/Jeroen-G/Hummingbird/Main%20CI?style=flat-square)

Validate your DOM to be SEO-proof.

## Quickstart

The best way to use this is by using the Docker container:

```bash
docker run --it --rm jeroeng/hummingbird:dev evaluate:url github.com
```

You may replace `dev` with a tagged release number for more stability.

## Usage

### Evaluate URL

```bash
evaluate:url <url(s)>
```

You may give multiple urls, separated by a space.

```bash
evaluate:url github.com enrise.com
```

By default, it will run all assertions. You may pass your preferred set of assertions.
For example, to only test for the h1 and open graph tags:

```bash
evaluate:url github.com -a h1,og
```

## Change log

Please see the [changelog](changelog.md) for more information on what has changed recently.

## Contributing

There is a Makefile in the repository, run `make install` to quickly get started.
After that, to try out any command, do not keep rebuilding the Docker container but instead call the commands like this:

```bash
php bin/console evaluate:url
```

## Credits

- [Jeroen][link-author]
- [All Contributors][link-contributors]

[link-author]: https://github.com/jeroen-g
[link-contributors]: ../../contributors
  
## License

MIT. Please see the [license file](LICENSE) for more information.

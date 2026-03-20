const path = require('path');

const MiniCssExtractPlugin = require('mini-css-extract-plugin');

const pluginname = 'poeticsoft-heart';
const destdir = path.join(__dirname, pluginname);
const public = '/wp-content/plugins/' + pluginname;

module.exports = (env) => {
    const input = Object.keys(env)[2] || '';
    const params = input.split('-');
    const type = params[0] || 'frontend'; // frontend | admin | block
    const name = params[1] || 'base'; // base | etc.
    const mode = params[2] || 'dev'; // dev | prod
    const watch = params[3] || 'si'; // si | no
    const cssfilename = '[name].css';

    const wpblockexternals = {
        '@wordpress/element': 'wp.element',
        '@wordpress/i18n': 'wp.i18n',
        '@wordpress/blocks': 'wp.blocks',
        react: 'window.React',
        'react-dom': 'window.ReactDOM'
    };
    const wpcompexternals = {
        react: 'wp.element',
        'react-dom': 'wp.element'
    };

    let externals;

    switch (type) {
        case 'common':
        case 'admin':
            externals = wpblockexternals;

            break;

        case 'frontend':
            externals = wpcompexternals;

            break;

        default:
            break;
    }

    const output = path.resolve(__dirname, pluginname + '/ui/' + type);
    let entry = {
        main: './src/' + type + '/main.js'
    };

    console.log('--------------------------');
    console.log('context: ' + path.resolve(__dirname));
    console.log('destdir: ' + destdir);
    console.log('type: ' + type);
    console.log('name: ' + name);
    console.log('mode: ' + mode);
    console.log('watch: ' + watch);
    console.log('public: ' + public);
    console.log('output: ' + output);
    console.log('entry: ' + JSON.stringify(entry, null, 4));
    console.log('--------------------------');

    const config = {
        context: __dirname,
        stats: 'minimal',
        watch: watch == 'si',
        name: 'minimal',
        entry: entry,
        output: {
            path: output,
            publicPath: public,
            filename: '[name].js',
            clean: true
        },
        mode: mode == 'prod' ? 'production' : 'development',
        devtool: mode == 'prod' ? false : 'source-map',
        module: {
            rules: [
                {
                    test: /\.jsx?$/,
                    exclude: /node_modules/,
                    use: [
                        {
                            loader: 'babel-loader',
                            options: {
                                presets: [
                                    '@babel/preset-env',
                                    '@babel/preset-react'
                                ]
                            }
                        }
                    ]
                },
                {
                    test: /\.s[ac]ss$/i,
                    exclude: /node_modules/,
                    use: [
                        {
                            loader: MiniCssExtractPlugin.loader
                        },
                        {
                            loader: 'css-loader'
                        },
                        {
                            loader: 'sass-loader',
                            options: {
                                sassOptions: {
                                    api: 'modern'
                                }
                            }
                        }
                    ]
                },
                {
                    test: /\.css$/,
                    include: /node_modules/,
                    use: [
                        {
                            loader: MiniCssExtractPlugin.loader
                        },
                        'css-loader'
                    ]
                },
                // Assets
                {
                    test: /\.(jpg|jpeg|png|gif|svg|woff|ttf|eot|mp3|woff|woff2|webm|mp4)$/,
                    type: 'asset/resource',
                    generator: {
                        emit: false,
                        filename: (content) => {
                            return content.filename.replace(pluginname, '');
                        }
                    }
                }
            ]
        },
        plugins: [
            new MiniCssExtractPlugin({
                filename: cssfilename
            })
        ],
        resolve: {
            extensions: ['.js'],
            alias: {
                assets: path.resolve(destdir + '/assets'),
                block: path.join(__dirname, pluginname, 'block'),
                common: path.join(__dirname, 'src', 'common'),
                adminjs: path.join(__dirname, 'src', 'admin', 'js'),
                adminscss: path.join(__dirname, 'src', 'admin', 'scss')
            }
        },
        externals: externals
    };

    console.log(path.join(__dirname, 'src', 'common', 'js', 'components'));

    return config;
};
